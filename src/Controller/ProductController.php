<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    private ProductManager $productManager;
    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    #[Route('/product', name: 'product_list')]
    public function list(ProductManager $productManager): Response
{
    $products = $productManager->getAllProducts(); // Esto debería traer los productos

    dd($products);

    return $this->render('menu/menu.html.twig', [
        'productos' => $products, // Aquí le pasas la variable productos a la vista
    ]);
}

}
