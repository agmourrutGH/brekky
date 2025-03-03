<?php

namespace App\Controller;

use App\Manager\RecomendacionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RecomendacionController extends AbstractController
{
    private $recomendacionManager;

    public function __construct(RecomendacionManager $recomendacionManager)
    {
        $this->recomendacionManager = $recomendacionManager;
    }

    #[Route('/recomendaciones', name: 'app_recomendaciones')]
    public function index(Request $request): Response
    {
        $tipo = $request->query->get('tipo');
        $categoria = $request->query->get('categoria');
        $dias = $request->query->get('dias');

        $recomendaciones = $this->recomendacionManager->obtenerRecomendaciones($tipo, $categoria, $dias);

        return $this->render('recomendacion/recomendacion.html.twig', [
            'recomendaciones' => $recomendaciones
        ]);
    }
}
