<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\RegisterManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, RegisterManager $registerManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($request->isMethod('POST')) {
            $nombre = $request->get('nombre');
            $email = $request->get('email');
            $password = $request->get('password');

            // Validar el nombre
            if (!$this->isNombreValido($nombre)) {
                $this->addFlash('error', 'El nombre debe tener al menos 2 caracteres y no debe contener caracteres especiales.');
                return $this->redirectToRoute('app_register');
            }

            // Validar la contraseña
            if (!$this->isPasswordValid($password, $email, $nombre)) {
                $this->addFlash('error', 'La contraseña no cumple con los requisitos de seguridad.');
                return $this->redirectToRoute('app_register');
            }

            // Hashea la contraseña antes de guardarla
            $hashedPassword = $passwordHasher->hashPassword(new User(), $password);

            // Registrar el usuario
            $usuario = $registerManager->register($nombre, $email, $hashedPassword);

            if (!$usuario) {
                $this->addFlash('error', 'El correo ya está registrado.');
                return $this->redirectToRoute('app_register');
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('register/register.html.twig');
    }

    
    private function isNombreValido(string $nombre): bool
    {
        return preg_match('/^[a-zA-Z0-9 ]{2,}$/', $nombre); // Al menos 2 caracteres, sin caracteres especiales
    }

    // Función para validar la contraseña
    private function isPasswordValid(string $password, string $email, string $nombre): bool
    {
        if (strlen($password) < 8) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/\d/', $password)) {
            return false;
        }

        if (!preg_match('/[!@#$%^&*]/', $password)) {
            return false;
        }

        if ($password === $email || $password === $nombre) {
            return false;
        }

        return true;
    }
}
