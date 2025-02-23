<?php

namespace App\Manager;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductManager
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Obtiene todos los productos.
     *
     * @return Product[]
     */
    // En ProductManager
    public function getAllProducts()
    {
        $products = $this->productRepository->findAll();
        return $products;
    }

    public function getProduct(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }
}
