<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCommandeFleur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\FleurRepository;
use App\Repository\CommandeRepository;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(CommandeRepository $repoCommande): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isGranted('ROLE_ADMIN')) {

            $commande = $repoCommande->findAll();

        } 
        else 
        {
            $commande = $repoCommande->findByUtilisateur(
                $this->getUser()->getId()
            );
        }

        return $this->render('commande/commande.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/commande/add", name="commande_add")
     */
    public function add(
        SessionInterface $session,
        FleurRepository $repoFleur
    ): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();
        $uneCde = new Commande();
        $uneCde->setDate(new \DateTime());
        $uneCde->setUnUtilisateur($this->getUser());

        $panier = $session->get('panier', []);

        foreach ($panier as $id => $quantite) {
            $uneLC = new LigneCommandeFleur();
            $uneLC->setQuantite($quantite);
            $uneFleur = $repoFleur->find($id);
            $uneLC->setUneFleur($uneFleur);
            $uneCde->addLigneCommandeFleur($uneLC);
        }

        $entityManager->persist($uneCde);
        $entityManager->flush();

        $session->set('panier', []);

        return $this->render('commande/add.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
