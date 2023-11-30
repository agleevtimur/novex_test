<?php

namespace App\Service\Validation\PhoneNumber;

use App\Service\PhoneNumberHelper;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PhoneConstraintValidator extends ConstraintValidator
{
    private array $phoneNumberRules = [
        '/^\+7\d{10}$/',    // россия, казахстан
        '/^\+380\d{9}$/',   // украина
        '/^\+375\d{9}$/'    // беларусь
    ];

    public function __construct(private PhoneNumberHelper $phoneNumberHelper)
    {
    }

    public function validate(mixed $value, Constraint $constraint = null): bool
    {
        $value = $this->phoneNumberHelper->unify($value);

        foreach ($this->phoneNumberRules as $rule) {
            if (preg_match($rule, $value)) {
                return true;
            }
        }

        if ($constraint !== null) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

        return false;
    }
}