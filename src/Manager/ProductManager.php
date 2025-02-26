<?php

namespace App\Manager;

use App\Entity\Categoria;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ProductManager
{
    private ProductRepository $productRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
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

    public function createProduct(string $nombre, string $descripcion, float $precio, Categoria $categoria, ?UploadedFile $imagen = null, string $categoriaTipo = 'otros'): Product
    {
        $product = new Product();
        $product->setNombre($nombre);
        $product->setDescripcion($descripcion);
        $product->setPrice($precio);
        $product->setCategoria($categoria);

        // Manejar la imagen si se sube una
        if ($imagen) {
            $nombreArchivo = $imagen->getClientOriginalName(); // Obtener el nombre original del archivo

            // Definir la carpeta donde se almacenará la imagen
            $folderPath = 'public/images/' . strtolower($categoria->getNombre()); // Carpeta según el nombre de la categoría
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0777, true); // Crear la carpeta si no existe
            }

            try {
                // Mover la imagen a la carpeta correspondiente
                $imagen->move($folderPath, $nombreArchivo); // Guardar solo el nombre del archivo
                $product->setImagen($nombreArchivo); // Guardar solo el nombre del archivo sin la ruta
            } catch (FileException $e) {
                throw new \Exception('Error al subir la imagen');
            }
        }


        // Guardar el producto en la base de datos
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}
