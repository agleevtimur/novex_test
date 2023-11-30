<?php

namespace App\Service\ModelManager;

use App\DTO\UserDTO\UserDTO;
use App\Entity\Sex;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Манипуляция объектом класса User
 * Входные данные валидируются
 */
class UserManager implements UserManagerInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function create(UserDTO $userDTO): User|ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($userDTO);

        if (count($errors) !== 0) {
            return $errors;
        }

        $sex = $userDTO->sex !== null ? Sex::from($userDTO->sex) : null;
        $birthday = $userDTO->birthday !== null ? new DateTime($userDTO->birthday) : null;

        return (new User())
            ->setName($userDTO->name)
            ->setEmail($userDTO->email)
            ->setPhone($userDTO->phone)
            ->setAge($userDTO->age)
            ->setSex($sex)
            ->setBirthday($birthday)
            ->setCreatedAt(new DateTimeImmutable());
    }

    public function update(User $user, UserDTO $userDTO): bool|ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($userDTO);

        if (count($errors) !== 0) {
            return $errors;
        }

        $sex = $userDTO->sex !== null ? Sex::from($userDTO->sex) : null;
        $birthday = $userDTO->birthday !== null ? new DateTime($userDTO->birthday) : null;

        $user
            ->setName($userDTO->name)
            ->setEmail($userDTO->email)
            ->setPhone($userDTO->phone)
            ->setAge($userDTO->age)
            ->setSex($sex)
            ->setBirthday($birthday)
            ->setUpdatedAt(new DateTimeImmutable());

        return true;
    }

}