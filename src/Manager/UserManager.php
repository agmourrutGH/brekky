<?php
namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Retorna un array con los datos necesarios del usuario.
     *
     * @param User $user
     * @return array
     */
    public function getUserDetails(User $user): array
    {
        return [
            'email' => $user->getEmail(),
            'nombre' => $user->getNombre(),
            'profilePicture' => $user->getProfilePicture(),
        ];
    }

    /**
     * Actualiza los datos del perfil del usuario.
     *
     * @param User $user
     * @param array $data
     */
    public function updateProfile(User $user, array $data): void
    {
        if (isset($data['nombre'])) {
            $user->setNombre($data['nombre']);
        }
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['profilePicture'])) {
            $user->setProfilePicture($data['profilePicture']);
        }
        if (!empty($data['password'])) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
