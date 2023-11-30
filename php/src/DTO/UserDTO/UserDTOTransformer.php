<?php

namespace App\DTO\UserDTO;

use App\Entity\User;

class UserDTOTransformer
{
    public function createFromJSON(string $json): UserDTO
    {
        $data = json_decode($json, true);

        $userDTO = new UserDTO();

        $userDTO->name = $data['name'] ?? null;
        $userDTO->age = $data['age'] ?? null;
        $userDTO->birthday = $data['birthday'] ?? null;
        $userDTO->email = $data['email'] ?? null;
        $userDTO->phone = $data['phone'] ?? null;
        $userDTO->sex = $data['sex'] ?? null;

        return $userDTO;
    }

    public function createFromEntity(User $user): UserDTO
    {
        $userDTO = new UserDTO();

        $userDTO->id = $user->getId();
        $userDTO->name = $user->getName();
        $userDTO->age = $user->getAge();
        $userDTO->birthday = $user->getBirthday()?->format('Y-m-d');
        $userDTO->email = $user->getEmail();
        $userDTO->phone = $user->getPhone();
        $userDTO->sex = $user->getSex()?->value;;

        return $userDTO;
    }
}