<?php
// src/Controller/RecomendacionController.php
namespace App\Controller;

use App\Service\RecomendacionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RecomendacionController extends AbstractController
{
    public function __construct(private RecomendacionManager $recomendacionManager) {}

    #[Route('/recomendaciones', methods: ['GET'])]
    public function obtenerRecomendaciones(Request $request): JsonResponse
    {
        $tipo = $request->query->get('tipo', 'comida');
        $recomendaciones = $this->recomendacionManager->obtenerRecomendacionesPorTipo($tipo);

        return $this->json($recomendaciones);
    }
}