<?php

namespace App\Manager;

use App\Entity\User;
use App\Entity\Galeria;
use App\Entity\Calificacion;
use Doctrine\ORM\EntityManagerInterface;

class GaleriaManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveGaleria(Galeria $galeria): void
    {
        $this->entityManager->persist($galeria);
        $this->entityManager->flush();
    }

    public function addCalificacion(Calificacion $calificacion): void
    {
        $this->entityManager->persist($calificacion);
        $this->entityManager->flush();
    }

    public function getGalerias(): array
    {
        return $this->entityManager->getRepository(Galeria::class)->findAll();
    }

    public function getCalificaciones(Galeria $galeria): array
    {
        return $this->entityManager->getRepository(Calificacion::class)->findBy(['galeria' => $galeria]);
    }
    public function getGaleriaById(int $id): ?Galeria
    {
        return $this->entityManager->getRepository(Galeria::class)->find($id);
    }
    public function getCalificacionUsuarioEntity(Galeria $galeria, User $user): ?Calificacion
    {
        return $this->entityManager->getRepository(Calificacion::class)
            ->findOneBy(['galeria' => $galeria, 'user' => $user]);
    }
}
