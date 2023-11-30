<?php

use App\Service\PhoneNumberHelper;
use App\Service\Validation\PhoneNumber\PhoneConstraintValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    #[DataProvider('unifyProvider')]
    public function testUnify(string $phoneNumber, string $expected)
    {
        $helper = new PhoneNumberHelper();
        $this->assertSame($expected, $helper->unify($phoneNumber));
    }

    #[DataProvider('validateProvider')]
    public function testValidate(string $phoneNumber)
    {
        $validator = new PhoneConstraintValidator(new PhoneNumberHelper());
        $this->assertTrue($validator->validate($phoneNumber));
    }

    public static function unifyProvider(): array
    {
        return [
            ['79995553434', '+79995553434'],
            ['89995553434', '+79995553434'],
            ['7 (999) 555-34-34', '+79995553434']
        ];
    }

    public static function validateProvider(): array
    {
        return [
            'rus1' => ['+79995553434'],
            'rus2' => ['7(999)555-34-34'],
            'ukr' => ['380444618061'],
            'blr' => ['+375242223434']
        ];
    }
}