<?php

namespace App\Controller;

use App\Manager\ProductManager;
use App\Repository\CategoriaRepository;
use App\Entity\Categoria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends AbstractController
{
    private ProductManager $productmanager;
    private CategoriaRepository $categoriaRepository;
    public function __construct(ProductManager $productManager, CategoriaRepository $categoriaRepository)
    {
        $this->productmanager = $productManager;
        $this->categoriaRepository = $categoriaRepository;
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

    #[Route('/product/{idProduct}', name: 'detalle_product', requirements: ['idProduct' => '\d+'])]
    public function detalle_product(int $idProduct): Response
    {
        $product = $this->productmanager->getProduct((int) $idProduct); 

        if (!$product) {
            throw $this->createNotFoundException('Producto no encontrado.');
        }

        return $this->render('detalle/detalle.html.twig', ['productos' => $product]);
    }

    #[Route('/product/new', name: 'new_product')]
    public function new(): Response
    {
        // Obtener todas las categorías de la base de datos
        $categorias = $this->categoriaRepository->findAll();

        
        return $this->render('menu/new.html.twig', [
            'categorias' => $categorias,
        ]);
    }


    #[Route('/product/create', name: 'create_product', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $nombre = $request->request->get('nombre');
        $descripcion = $request->request->get('descripcion');
        $precio = (float) $request->request->get('precio');
        $categoriaNombre = $request->request->get('categoria');
        $imagen = $request->files->get('imagen');

        // Definir las categorías predefinidas
        $bebidasCategorias = ['Bebidas Frias', 'Jugos Helados', 'Té Caliente', 'Bebidas Calientes'];
        $comidasCategorias = ['Porridge', 'Sandwich', 'Focaccia'];

        // Verificar en qué categoría se encuentra
        if (in_array($categoriaNombre, $bebidasCategorias)) {
            $categoriaTipo = 'bebidas';
        } elseif (in_array($categoriaNombre, $comidasCategorias)) {
            $categoriaTipo = 'comidas';
        } else {
            $categoriaTipo = 'otros'; 
        }

        // Buscar la categoría en la base de datos
        $categoriaNombre = $request->request->get('categoria');
        $categoria = $this->categoriaRepository->findOneBy(['nombre' => $categoriaNombre]);


        if (!$categoria) {
            $this->addFlash('error', 'La categoría no existe.');
            return $this->redirectToRoute('new_product');
        }

        // Crear el producto
        $producto = $this->productmanager->createProduct($nombre, $descripcion, $precio, $categoria, $imagen);

        // Redirigir al detalle del producto recién creado
        return $this->redirectToRoute('detalle_product', ['idProduct' => (int) $producto->getId()]);
    }

    #[Route('/product/edit/{idProduct}', name: 'edit_product')]
    public function edit(int $idProduct): Response
    {
        $product = $this->productmanager->getProduct($idProduct);

        if (!$product) {
            throw $this->createNotFoundException('Producto no encontrado.');
        }

        $categorias = $this->categoriaRepository->findAll();

        return $this->render('menu/edit.html.twig', [
            'producto' => $product,
            'categorias' => $categorias,
        ]);
    }

    #[Route('/product/update/{idProduct}', name: 'update_product', methods: ['POST'])]
    public function update(Request $request, int $idProduct): Response
    {
        $product = $this->productmanager->getProduct($idProduct);

        if (!$product) {
            throw $this->createNotFoundException('Producto no encontrado.');
        }

        $nombre = $request->request->get('nombre');
        $descripcion = $request->request->get('descripcion');
        $precio = (float) $request->request->get('precio');
        $categoriaNombre = $request->request->get('categoria');
        $imagen = $request->files->get('imagen');

        $categoria = $this->categoriaRepository->findOneBy(['nombre' => $categoriaNombre]);

        if (!$categoria) {
            $this->addFlash('error', 'La categoría no existe.');
            return $this->redirectToRoute('edit_product', ['idProduct' => $idProduct]);
        }

        $this->productmanager->updateProduct($product, $nombre, $descripcion, $precio, $categoria, $imagen);

        return $this->redirectToRoute('detalle_product', ['idProduct' => $idProduct]);
    }

    #[Route('/product/delete/{idProduct}', name: 'delete_product', methods: ['POST'])]
    public function delete(int $idProduct): Response
    {
        $product = $this->productmanager->getProduct($idProduct);

        if (!$product) {
            throw $this->createNotFoundException('Producto no encontrado.');
        }

        $this->productmanager->deleteProduct($product);

        return $this->redirectToRoute('product_list');
    }
}
