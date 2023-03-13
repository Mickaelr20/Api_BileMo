<?php

namespace App\Serializer;

use App\Entity\Product;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ProductNormalizer implements NormalizerInterface
{

    public function __construct(private UrlGeneratorInterface $router, private ObjectNormalizer $normalizer)
    {
    }

    public function normalize($product, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($product, $format, $context);

        $data['_links']['self'] = $this->router->generate('api_products_view', [
            'id' => $product->getId(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
        
        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Product;
    }
}
