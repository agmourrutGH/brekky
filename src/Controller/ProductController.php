<?php

namespace App\Controller;

use App\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends AbstractController
{
    private ProductManager $productmanager;
    public function __construct(ProductManager $productManager)
    {
        $this->productmanager = $productManager;
    }

    #[Route('/product', name: 'product_list')]
    public function list(ProductManager $productManager): Response
    {
        $products = $productManager->getAllProducts();

        $bebidas = [];
        $comidas = [];

        foreach ($products as $product) {
            $categoriaNombre = $product->getCategoria()->getNombre();

            // Separar productos en bebidas y comidas
            if (in_array($categoriaNombre, ['Bebidas Frias', 'Jugos Helados', 'Té Caliente', 'Bebidas Calientes'])) {
                $bebidas[] = $product;
            } elseif (in_array($categoriaNombre, ['Porridge', 'Sandwich', 'Focaccia'])) {
                $comidas[] = $product;
            }
        }

        return $this->render('menu/menu.html.twig', [
            'bebidas' => $bebidas,
            'comidas' => $comidas,
        ]);
    }

    #[Route('/product/{idProduct}', name: 'detalle_product')]
    public function detalle_product($idProduct): Response
    {
        $product = $this->productmanager->getProduct($idProduct);
        return $this->render('detalle/detalle.html.twig',['productos'=>$product]);
    }
}
