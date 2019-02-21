<?php

namespace App\Controller;


use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion.html", name="security_connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexion(AuthenticationUtils $authenticationUtils)
    {
        # Récupération du formulaire de connexion
        $form = $this->createForm(LoginFormType::class, [
            'email' => $authenticationUtils->getLastUsername()
        ]);

        # Récupération du message d'erreur
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/connexion.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/deconnexion.html",
     *     name="security_deconnexion")
     */
    public function deconnexion()
    {
    }
}
