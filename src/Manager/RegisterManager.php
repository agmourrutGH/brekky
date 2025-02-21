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
        // Verifica si ya existe un usuario con ese email
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            return null; // El email ya está en uso
        }

        // Crear el nuevo usuario
        $user = new User();
        $user->setNombre($nombre);
        $user->setEmail($email);
        $user->setPassword($password);  // Ya codificado
        $user->setRoles(['ROLE_USER']); // Asignar el rol por defecto

        // Guardar en la base de datos
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
