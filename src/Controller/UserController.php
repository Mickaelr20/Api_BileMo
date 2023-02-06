<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/users', name: 'api_users_')]
class UserController extends AbstractController
{

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request, UserRepository $userRepository): Response
    {
        /** @var Client $client */
        $client = $this->getUser();
        return $this->json($client->getUsers(), Response::HTTP_OK, [], ['groups' => ['read']]);
    }

    #[Route('', name: 'new', methods: ['POST'])]
    public function new(Request $request, UserRepository $userRepository, ValidatorInterface $validator, SerializerInterface $serializer): Response
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        $user->setClient($this->getUser());
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $this->json(["errors" => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userRepository->new($user);

        return $this->json($user, Response::HTTP_CREATED, [], ['groups' => ['read']]);
    }
}
