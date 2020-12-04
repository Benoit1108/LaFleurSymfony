<?php

namespace App\Controller;

use App\Repository\FleurRepository;
use App\Repository\CategorieRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FleurController extends AbstractController
{
    /**
     * @Route("/fleur", name="fleur")
     */
    public function index(FleurRepository $fleurRepo, CategorieRepository $categorieRepo): Response
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
}
