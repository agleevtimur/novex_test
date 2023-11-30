<?php

namespace App\Entity;

enum Sex: string
{
    case FEMALE = 'female';
    case MALE = 'male';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}