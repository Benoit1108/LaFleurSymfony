<?php

namespace App\Controller;

use App\Entity\Fleur;
use App\Form\FleurType;
use App\Repository\FleurRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/fleur")
 */
class FleurController extends AbstractController
{
    /**
     * @Route("/", name="fleur_index", methods={"GET"})
     * IsGranted("ROLE_ADMIN")
     */
    public function index(FleurRepository $fleurRepository): Response
    {
        return $this->render('fleur/index.html.twig', [
            'fleurs' => $fleurRepository->findAll(),
        ]);
    }
    /**
     * @Route("/fleur", name="fleur")
     */
    public function catalogue(FleurRepository $fleurRepo, CategorieRepository $categorieRepo): Response
    {
        $lesFleurs = $fleurRepo->findAll();
        $lesCategories = $categorieRepo->findAll();

        return $this->render('fleur/catalogue.html.twig', [
            'lesFleurs' => $lesFleurs,
            'lesCategories' => $lesCategories,
        ]);
    }

    
    /**
     * @Route("/fleur/{id}", name="fleurByCateg")
     */
    public function fleurByCateg($id,  FleurRepository $fleurRepo, CategorieRepository $categorieRepo): Response
    {
        $lesFleurs = $fleurRepo->findBy(['uneCategorie' => $id]);
        $lesCategories = $categorieRepo->findAll();

        return $this->render('fleur/catalogue.html.twig', [
            'lesFleurs' => $lesFleurs,
            'lesCategories' => $lesCategories,
        ]);
    }

    /**
     * @Route("/new", name="fleur_new", methods={"GET","POST"})
     * IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $fleur = new Fleur();
        $form = $this->createForm(FleurType::class, $fleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fleur);
            $entityManager->flush();

            return $this->redirectToRoute('fleur_index');
        }

        return $this->render('fleur/new.html.twig', [
            'fleur' => $fleur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fleur_show", methods={"GET"})
     * IsGranted("ROLE_ADMIN")
     */
    public function show(Fleur $fleur): Response
    {
        return $this->render('fleur/show.html.twig', [
            'fleur' => $fleur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fleur_edit", methods={"GET","POST"})
     * IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Fleur $fleur): Response
    {
        $form = $this->createForm(FleurType::class, $fleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fleur_index');
        }

        return $this->render('fleur/edit.html.twig', [
            'fleur' => $fleur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fleur_delete", methods={"DELETE"})
     * IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Fleur $fleur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fleur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fleur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fleur_index');
    }
}
