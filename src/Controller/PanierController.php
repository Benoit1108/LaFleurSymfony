<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\FleurRepository;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier_index")
     */
    public function index(FleurRepository $fleurRepo, SessionInterface $session): Response {
        $panier = $session->get('panier', []);
        $panierAvecDonnees = [];

        foreach ($panier as $id => $quantite) {
            $panierAvecDonnees[] = [
                'fleur' => $fleurRepo->find($id),
                'qte' => $quantite,
            ];
        }
        //dd($panierAvecDonnees); Didier le meilleur de tous les routiers 7 fois palme d'or de la meilleur conduite avec son bide

        return $this->render('panier/index.html.twig', [
            'lesfleurs' => $panierAvecDonnees,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="add_panier")
     */
    public function add($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            // L'id est présente
            $panier[$id]++;
        } else {
            //l'id n'est pas présente
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        //dd($panier);
        $this->addFlash('panier', 'Le produit a été ajouté au panier');

        return $this->redirectToRoute('fleur');
    }
    /**
     * @Route("/panier/plus/{id}", name="plus_panier")
     */
    public function plus($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            // L'id est présente
            $panier[$id]++;
        } else {
            //l'id n'est pas présente
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        //dd($panier);
        $this->addFlash('panier', 'Le produit a été ajouté au panier');

        return $this->redirectToRoute('panier_index');
    }
    /**
     * @Route("/panier/less/{id}", name="less_panier")
     */
    public function less($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            // L'id est présente
            $panier[$id]--;

            if ($panier[$id] == 0) {
                unset($panier[$id]);
            }
        }
        $session->set('panier', $panier);
        //dd($panier);
        $this->addFlash('panier', 'La quantité à diminuer');

        return $this->redirectToRoute('panier_index');
    }
    /**
     * @Route("/panier/remove/{id}", name="remove_panier")
     */
    public function remove($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            // L'id est présente
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        //dd($panier);
        $this->addFlash('panier', 'Le produit a été supprimer du panier !');

        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/panier/vider", name="vider_panier")
     */
    public function vider(SessionInterface $session): Response
    {
        $session->set('panier', []);
        //dd($panier);
        $this->addFlash('panier', 'Le panier a été vider !');

        return $this->redirectToRoute('panier_index');
    }
    public function nbProdPanier(SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        $total = 0;
        foreach ($panier as $id => $quantite) {
            $total = $total + $quantite;
        }
        return $this->render('panier/nbProdPanier.html.twig', ['nb' => $total]);
    }
}
