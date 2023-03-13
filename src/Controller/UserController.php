<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/users', name: 'api_users_')]
class UserController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request, UserRepository $userRepository): Response
    {
        /** @var \App\Entity\Client $client */
        $client = $this->getUser();
        $limit = 3;
        $page = $request->query->getInt('page', 1) >= 1 ? $request->query->getInt('page', 1) : 1;
        $users = $userRepository->listPage($client, $page, $limit);
        $total = $userRepository->countAll();
        $count = count($users);
        $pages = ceil($total / $limit);

        $results = [
            'page' => $page,
            'pages' => $pages,
            'count' => $count,
            'total' => $total,
            'limit' => $limit,
            '_links' => [
                'first' => $this->generateUrl('api_users_list', ['page' => 1], UrlGeneratorInterface::ABSOLUTE_URL),
                'last' => $this->generateUrl('api_users_list', ['page' => $pages], UrlGeneratorInterface::ABSOLUTE_URL),
                'next' => ($page + 1) <= $pages ? $this->generateUrl('api_users_list', ['page' => $page + 1], UrlGeneratorInterface::ABSOLUTE_URL) : null,
                'previous' => ($page - 1) >= 1 ? $this->generateUrl('api_users_list', ['page' => $page - 1], UrlGeneratorInterface::ABSOLUTE_URL) : null,
            ],
            '_embedded' => [
                'items' => $users,
            ],
        ];

        return $this->json($results, Response::HTTP_OK, [], ['groups' => ['read']]);
    }

    #[Route('', name: 'new', methods: ['POST'])]
    public function new(Request $request, UserRepository $userRepository, ValidatorInterface $validator, SerializerInterface $serializer): Response
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        $user->setClient($this->getUser());
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userRepository->new($user);

        return $this->json($user, Response::HTTP_CREATED, [], ['groups' => ['read']]);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], name: 'view', methods: ['GET'])]
    public function view(User $user): Response
    {
        if (!$this->isGranted('view', $user)) {
            throw new NotFoundHttpException();
        }

        return $this->json($user, Response::HTTP_OK, [], ['groups' => ['read']]);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], name: 'delete', methods: ['DELETE'])]
    public function delete(User $user, UserRepository $userRepository): Response
    {
        if (!$this->isGranted('delete', $user)) {
            throw new NotFoundHttpException();
        }

        $userRepository->remove($user);

        return $this->json(null, Response::HTTP_NO_CONTENT, [], ['groups' => ['read']]);
    }
}
