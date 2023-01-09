<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// #[Route('/products', name: 'app_products_')]
class ProductController extends AbstractController
{

    #[Route('/products/list', name: 'list', methods: ['GET'])]
    public function list(Request $request, ProductRepository $productRepository): Response
    {
        $products = $productRepository->listPage($request->query->getInt("page", 1), 1);
        // $products = ["test" => "test"];
        return $this->json($products);
    }

    #[Route('/products/{id}', name: 'view', methods: ['GET'])]
    public function view(Product $product): Response
    {
        return $this->json($product);
    }
}
