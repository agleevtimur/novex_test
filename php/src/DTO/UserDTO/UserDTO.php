<?php

namespace App\DTO\UserDTO;

use App\Entity\Sex;
use App\Service\Validation\PhoneNumber\PhoneConstraint;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

class UserDTO implements JsonSerializable
{
    public ?int $id = null;
    #[Assert\NotBlank]
    public ?string $name;
    #[Assert\Email]
    public ?string $email;
    #[PhoneConstraint]
    public ?string $phone;
    #[Assert\Choice(callback: [Sex::class, 'values'])]
    public ?string $sex;
    #[Assert\Range(min: 1, max: 100)]
    public ?int $age;
    #[Assert\Date]
    public ?string $birthday;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'sex' => $this->sex,
            'age' => $this->age,
            'birthday' => $this->birthday
        ];
    }
}