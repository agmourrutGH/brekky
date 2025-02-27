<?php
// src/Service/RecomendacionManager.php
namespace App\Service;

use App\Entity\Recomendacion;
use Doctrine\ORM\EntityManagerInterface;

class RecomendacionManager
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function obtenerRecomendacionesPorTipo(string $tipo): array
    {
        return $this->entityManager->getRepository(Recomendacion::class)->findBy(['tipo' => $tipo]);
    }
}