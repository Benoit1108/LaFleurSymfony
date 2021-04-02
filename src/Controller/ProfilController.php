<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ProfilMdpType;
use App\Form\ProfilInfosType;
use App\Form\ProfilPhotoType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(UtilisateurRepository $repoUtili, UserInterface $user): Response
    {
        $utilisateur = $repoUtili->findOneBy(['email' => $user->getUsername()]);

        return $this->render('profil/index.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

     /**
     * @Route("/profil/{id}/infos", name="profil_edit_infos", methods={"GET","POST"})
     */
    public function info(Request $request, Utilisateur $utilisateur): Response
    {

        $form = $this->createForm(ProfilInfosType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('profil');
        }
        
      

        return $this->render('profil/info.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }
     /**
     * @Route("/profil/{id}/mdp", name="profil_edit_mdp", methods={"GET","POST"})
     */
    public function mdp(Request $request, UserPasswordEncoderInterface $passwordEncoder, Utilisateur $utilisateur): Response
    {
        $form = $this->createForm(ProfilMdpType::class, $utilisateur);
        $form->handleRequest($request);

      
        if ($form->isSubmitted() && $form->isValid()) {

                $utilisateur->setPassword(
                $passwordEncoder->encodePassword(
                    $utilisateur,
                    $form->get('password')->getData()
                )
            );
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('profil');
        }
      

        return $this->render('profil/mdp.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/profil/{id}/photo", name="profil_edit_photo", methods={"GET","POST"})
     */
     public function photo(Request $request, Utilisateur $utilisateur, UserInterface $user): Response
    {
        if ($utilisateur->getUserName() != $user->getUserName())  // Contrôle si pas ursapation identité
            return $this->redirectToRoute('profil_index');

        $form = $this->createForm(ProfilPhotoType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $file = $utilisateur->getPhoto();

            if (!preg_match('/image\/.*/', $file->getClientMimeType())) 
            {
                $this->addFlash('profil', 'Le fichier doit être une image !');
            } 
            else 
            {
                if (($file->getClientOriginalExtension() != "jpg") and ($file->getClientOriginalExtension() != "png")) 
                {
                    
                    $this->addFlash('profil', 'Le fichier doit être une image JPEG ou PNG !');
                } 
                else 
                {
                    $utilisateur->setPhoto(file_get_contents($file));
                    $this->getDoctrine()->getManager()->flush();
                }
            }

            return $this->redirectToRoute('profil_index');
        }

        return $this->render('profil/photo.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }
}
