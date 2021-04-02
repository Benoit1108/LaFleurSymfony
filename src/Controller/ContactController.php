<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_index")
     */  
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            /* $this->addFlash(
                'okContact',
                'Votre demande a été bien enregistrée. Nous vous répondrons jamais.'
            );*/

            $mail = new \Swift_Message();
            $mail
                ->setSubject("Demande d'infos")
                ->setFrom('benoit.bruneau2001@gmail.com')
                ->setTo($contact->getMail())
                ->setBody(
                    $this->render('contact/mail.html.twig', [
                        'contact' => $contact,
                    ]),
                    'text/html'
                );

            if ($mailer->send($mail)) {
                $this->addFlash(
                    'okContact',
                    'Votre demande a été bien envoyé. Nous vous répondrons jamais.'
                );
            } else {
                $this->addFlash(
                    'okContact',
                    'Une erreur est survenue, veuillez recommencer'
                );
            }

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/index.html.twig', [
            'formContact' => $form->createView(),
        ]);
    }
}
