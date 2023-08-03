<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route("/logout", name: "app_logout")]

    public function logout(): Response
    {
        // Ta metoda zostanie automatycznie wywołana po wylogowaniu użytkownika
        // Ale nie trzeba umieszczać żadnej logiki tutaj, można ją pozostawić pustą

        // Ta linijka zostanie pominięta, ponieważ metoda zostanie wywołana po wylogowaniu
        throw new \Exception('This should never be reached!');
    }
}
