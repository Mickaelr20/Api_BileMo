<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/products', name: 'api_products_')]
class ProductController extends AbstractController
{
	// #[OA\Response(
	//     response: 200,
	//     description: 'Returns a list of products',
	//     content: new OA\JsonContent(
	//         type: 'array',
	//         items: new OA\Items(ref: new Model(type: Product::class, groups: ['read']))
	//     )
	// )]
	// #[OA\Parameter(
	//     name: 'page',
	//     in: 'query',
	//     description: 'La page a afficher',
	//     schema: new OA\Schema(type: 'integer', minProperties: 0)
	// )]
	// #[OA\Tag(name: 'rewards')]
	#[Route('', name: 'list', methods: ['GET'])]
	public function list(Request $request, ProductRepository $productRepository): Response
	{
		$limit = 10;
		$page = $request->query->getInt('page', 1) >= 1 ? $request->query->getInt('page', 1) : 1;
		$products = $productRepository->listPage($page, $limit);
		$total = $productRepository->countAll();
		$count = count($products);
		$pages = ceil($total / $limit);

		$results_links = [
			'first' => $this->generateUrl('api_products_list', ['page' => 1], UrlGeneratorInterface::ABSOLUTE_URL),
			'last' => $this->generateUrl('api_products_list', ['page' => $pages], UrlGeneratorInterface::ABSOLUTE_URL),
		];

		if (($page + 1) <= $pages) {
			$results_links['next'] = $this->generateUrl('api_products_list', ['page' => $page + 1], UrlGeneratorInterface::ABSOLUTE_URL);
		}

		if (($page - 1) >= 1) {
			$results_links['previous'] = $this->generateUrl('api_products_list', ['page' => $page - 1], UrlGeneratorInterface::ABSOLUTE_URL);
		}

		$results = [
			'page' => $page,
			'pages' => $pages,
			'count' => $count,
			'total' => $total,
			'limit' => $limit,
			'_links' => $results_links,
			'_embedded' => [
				'items' => $products,
			],
		];

		return $this->json($results, Response::HTTP_OK, [], ['groups' => ['read']]);
	}

	#[Route('/{id}', requirements: ['id' => '\d+'], name: 'view', methods: ['GET'])]
	public function view(Product $product): Response
	{
		return $this->json($product, Response::HTTP_OK, [], ['groups' => ['read']]);
	}
}
