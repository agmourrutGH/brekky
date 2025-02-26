<?php
// src/Controller/MapController.php

namespace App\Controller;

use App\Manager\MapManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    private MapManager $mapManager;

    public function __construct(MapManager $mapManager)
    {
        $this->mapManager = $mapManager;
    }

    #[Route('/ruta-al-mapa', name: 'app_mapa_tienda')]
    public function mostrarMapa()
    {
        $tiendas = $this->mapManager->obtenerTiendas();

        return $this->render('mapa/map.html.twig', [
            'tiendas' => $tiendas,
        ]);
    }
}
