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

    public function obtenerProducts():array
    {
        return $this->entityManager->getRepository(Product::class)
             ->findBy([]);
    }
}