<?php

namespace App\Serializer;

use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserNormalizer implements NormalizerInterface
{
	public function __construct(private UrlGeneratorInterface $router, private ObjectNormalizer $normalizer)
	{
	}

	public function normalize($user, string $format = null, array $context = [])
	{
		$data = $this->normalizer->normalize($user, $format, $context);

		$data['_links']['self'] = $this->router->generate('api_users_view', [
			'id' => $user->getId(),
		], UrlGeneratorInterface::ABSOLUTE_URL);
		$data['_links']['delete'] = $this->router->generate('api_users_delete', [
			'id' => $user->getId(),
		], UrlGeneratorInterface::ABSOLUTE_URL);

		return $data;
	}

	public function supportsNormalization($data, string $format = null, array $context = [])
	{
		return $data instanceof User;
	}
}
