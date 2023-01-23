<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products', name: 'api_products_')]
class ProductController extends AbstractController
{

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request, ProductRepository $productRepository): Response
    {
        $products = $productRepository->listPage($request->query->getInt("page", 1), 10);
        return $this->json($products);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], name: 'view', methods: ['GET'])]
    public function view(Product $product): Response
    {
        return $this->json($product);
    }
}
