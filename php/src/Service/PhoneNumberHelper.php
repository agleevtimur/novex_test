<?php

namespace App\Service;

class PhoneNumberHelper
{
    /**
     * Приводит номер телефона к виду "+код_страны"
     *
     * @param string $value
     * @return string
     */
    public function unify(string $value): string
    {
        $value = str_replace([' ', '(', ')', '-'], '', $value);

        if (str_starts_with($value, '8')) {
            $value = substr_replace($value, '+7', 0, 1);
        }

        if (!str_starts_with($value, '+')) {
            $value = '+' . $value;
        }

        return $value;
    }
}