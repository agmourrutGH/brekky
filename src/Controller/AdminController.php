<?php

namespace App\Controller;

use App\Manager\AdminManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    private AdminManager $adminManager;

    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    #[Route('/admin', name: 'admin_products')]
    public function index(): Response
    {
        $peliculas = $this->adminManager->obtenerProducts();


        return $this->render('admin/adminProducts.html.twig', [
            'products' => $products,
        ]);
    }
}
