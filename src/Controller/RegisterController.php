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
            
            // Hashea la contraseña usando UserPasswordHasherInterface
            $hashedPassword = $passwordHasher->hashPassword(
                new User(),  // Se crea un nuevo User solo para hashear la contraseña
                $password
            );
            

            // Llama al manager con la contraseña hasheada
            $usuario = $registerManager->register($nombre, $email, $hashedPassword);

            if (!$usuario) { 
                $this->addFlash('error', 'Las contraseñas no coinciden o el correo no es válido.');
                return $this->redirectToRoute('app_register');
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('register/register.html.twig');
    }
}
