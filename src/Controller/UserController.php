<?php
namespace App\Controller;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserController extends AbstractController
{
    private UserManager $userManager;
    private Security $security;

    public function __construct(UserManager $userManager, Security $security)
    {
        $this->userManager = $userManager;
        $this->security = $security;
    }

    #[Route('/perfil/editar', name: 'user_edit_profile')]
    public function editProfile(Request $request): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        if ($request->isMethod('POST')) {
            $data = [
                'nombre' => $request->request->get('nombre'),
                'email' => $request->request->get('email'),
                'password' => $request->request->get('password'),
            ];

            /** @var UploadedFile|null $profilePicture */
            $profilePicture = $request->files->get('profilePicture');
            if ($profilePicture) {
                $newFilename = uniqid() . '.' . $profilePicture->guessExtension();
                $profilePicture->move($this->getParameter('profile_pictures_directory'), $newFilename);
                $data['profilePicture'] = 'uploads/profile_pictures/' . $newFilename;
            }

            // Guardar los cambios en el usuario
            $this->userManager->updateProfile($user, $data);

            // Redirigir al menú principal
            return $this->redirectToRoute('app_home');

        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
