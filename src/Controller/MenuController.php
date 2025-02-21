<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MenuController extends AbstractController
{

    public function __construct(){

    }
        
    #[Route('/menu', name: 'app_menu')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        
        return $this->render('menu/menu.html.twig', [
            'products' => '$products',
        ]);
    }
}
