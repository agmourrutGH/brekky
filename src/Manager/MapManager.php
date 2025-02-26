<?php


namespace App\Manager;

use App\Entity\Tienda;
use Doctrine\ORM\EntityManagerInterface;

class MapManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function obtenerTiendas(): array
    {
        return $this->entityManager->getRepository(Tienda::class)->findAll();
    }
}
