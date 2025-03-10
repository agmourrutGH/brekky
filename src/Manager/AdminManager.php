<?php

namespace App\Manager;
use App\Entity\Galeria;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class AdminManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function obtenerProductosOrdenadosPorPrecio(): array
    {
        return $this->entityManager->getRepository(Product::class)
            ->findBy([], ['Price' => 'DESC']);
    }

    public function obtenerGaleriasOrdenadasPorPublicacion(bool $ordenDescendente = true): array
    {
        return $this->entityManager->getRepository(Galeria::class)
            ->findBy([], ['fechaPublicacion' => $ordenDescendente ? 'DESC' : 'ASC']);
    }
}
