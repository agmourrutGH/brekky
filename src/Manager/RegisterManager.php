<?php

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;



class RegisterManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Registra un nuevo usuario
     */
    public function register(string $nombre, string $email, string $password): ?User
    {
        
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            return null;
        }

        
        $user = new User();
        $user->setNombre($nombre);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);

        
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

}
