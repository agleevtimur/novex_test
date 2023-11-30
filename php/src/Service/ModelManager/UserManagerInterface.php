<?php

namespace App\Service\ModelManager;

use App\DTO\UserDTO\UserDTO;
use App\Entity\User;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface UserManagerInterface
{
    public function create(UserDTO $userDTO): User|ConstraintViolationListInterface;

    public function update(User $user, UserDTO $userDTO): bool|ConstraintViolationListInterface;
}