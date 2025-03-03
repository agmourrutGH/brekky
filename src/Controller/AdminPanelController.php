<?php

namespace App\Controller;

use App\Manager\AdminManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanelController extends AbstractController
{
    private AdminManager $adminManager;

    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    #[Route('/admin/productos', name: 'admin_productos')]
    // Obtener los productos desde el AdminManager
    public function index(): Response
    {
        // Obtener los productos desde el AdminManager
        $productos = $this->adminManager->obtenerProductosOrdenadosPorPrecio();  

        // Pasar los productos a la vista
        return $this->render('admin/adminProduct.html.twig', [
            'productos' => $productos,
        ]);
    }

    #[Route('/admin/galeria', name: 'admin_galeria')]
    public function indexGaleria(): Response
    {
        $galerias = $this->adminManager->obtenerGaleriasOrdenadasPorPublicacion();


        return $this->render('admin/adminGaleria.html.twig', [
            'galerias' => $galerias,
        ]);
    }
}
