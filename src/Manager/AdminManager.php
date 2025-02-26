<?php

namespace App\Manager;

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
            ->findBy([], ['Price' => 'DESC']);  // Puedes cambiar 'Price' por el campo que desees ordenar
    }
}
