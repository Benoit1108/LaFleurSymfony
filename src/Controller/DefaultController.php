<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="accueil_news")
     */
    public function index(NewsRepository $newsRepo): Response
    {
        $lesNews = $newsRepo->findAll();

        return $this->render('default/index.html.twig', [
            
            'lesNews' => $lesNews,
        ]);
    }

    /**
     * @Route("/add", name="add_news")
     */
    public function add(EntityManagerInterface $entityManager): Response
    {
        $uneNews = new News();
        $uneNews->setTitre("la news du jour");
        $uneNews->setContenu("Promo exceptionnelle");
        $uneNews->setDatenews(new \DateTime('2020/01/01'));
        $uneNews->setImage("test.jpg");

        $entityManager->persist($uneNews);

        $entityManager->flush();

        return $this->render('default/add.html.twig');
    }
}
?>