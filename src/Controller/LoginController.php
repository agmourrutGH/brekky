<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Obtener el último error de autenticación (si existe)
        $error = $authenticationUtils->getLastAuthenticationError();
        // Obtener el último nombre de usuario ingresado (en este caso el email)
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/detalles', name: 'app_detalles')]
    public function detalles(): Response
    {
        // Agrega el flash message
        $this->addFlash('info', 'Próximamente');
        // Redirige al usuario de nuevo a la página de login
        return $this->redirectToRoute('app_login');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \Exception('Activate logout in security.yaml');
    }
}
