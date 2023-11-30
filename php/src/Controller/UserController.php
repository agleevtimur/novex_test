<?php

namespace App\Controller;

use App\DTO\UserDTO\UserDTOTransformer;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ModelManager\UserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;


#[Route('/user')]
class UserController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository         $userRepository,
        private UserDTOTransformer     $DTOTransformer,
        private UserManagerInterface   $userManager
    )
    {
    }

    #[Route('/', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $userDTO = $this->DTOTransformer->createFromJSON($request->getContent());
        $result = $this->userManager->create($userDTO);

        if ($result instanceof User) {
            $this->entityManager->persist($result);
            $this->entityManager->flush();

            return new JsonResponse(['message' => 'User created successfully'], 201);
        }

        return new JsonResponse(['errors' => $this->transformErrors($result)], 400);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(string $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if ($user === null) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        return new JsonResponse(['user' => $this->DTOTransformer->createFromEntity($user)]);
    }

    #[Route('/', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $users = $this->userRepository->findAll();

        if ($users === []) {
            return new JsonResponse(['message' => 'Users not found'], 404);
        }

        return new JsonResponse(['users' => array_map(fn($user) => $this->DTOTransformer->createFromEntity($user), $users)]);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function edit(string $id, Request $request): JsonResponse
    {
        $userDTO = $this->DTOTransformer->createFromJSON($request->getContent());
        $user = $this->userRepository->find($id);

        if ($user === null) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        $result = $this->userManager->update($user, $userDTO);

        if ($result === true) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse(['message' => 'User updated successfully'], 200);
        }

        return new JsonResponse(['errors' => $this->transformErrors($result)], 400);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if ($user === null) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'User deleted successfully'], 200);
    }

    private function transformErrors(ConstraintViolationListInterface $errors): array
    {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errorMessages;
    }
}