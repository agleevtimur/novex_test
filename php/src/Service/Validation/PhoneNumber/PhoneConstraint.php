<?php

namespace App\Service\Validation\PhoneNumber;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class PhoneConstraint extends Constraint
{
    public string $message = 'некорректный номер телефона';
}