<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/security/connexion', name: 'security.login', methods:['GET', 'POST'])]
    public function connexion(AuthenticationUtils $authenticationUtils, Request $request): Response
    {   

            return $this->render('security/login.html.twig', [
             'last_username' => $authenticationUtils->getLastUsername(),
             'error' => $authenticationUtils->getLastAuthenticationError()
            ]);
    }

    #[Route('/security/deconnexion', name: 'security.logout')]
    public function deconnexion(): Response
    {
            return $this->render('security/login.html.twig', [
            ]);
    }
}
