<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact-moi",
     *     name="page_contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request)
    {

        # Création d'un Membre
        $contact = new contact();

        # Création du Formulaire
        $form = $this->createForm(ContactFormType::class, $contact)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            # Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            # Notification
            $this->addFlash('notice',
                'Félicitation, votre demande a été envoyée !');

            # Redirection
            return $this->redirectToRoute('page_contact');

        }

        return $this->render('front/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

}