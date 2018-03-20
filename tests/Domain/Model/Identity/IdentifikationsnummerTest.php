<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:17
 */

namespace App\Tests\Domain\Model\Identity;

use App\Domain\Model\Identity\Identifikationsnummer;
use PHPUnit\Framework\TestCase;

class IdentifikationsnummerTest extends TestCase
{
    /**
     * @dataProvider incorrectValuesProvider
     * @param string $number
     */
    public function testValidationForIncorrectValue(string $number)
    {
        $this->assertFalse(Identifikationsnummer::isNumberValid($number));
    }

    /**
     * @dataProvider correctValuesProvider
     * @param string $number
     */
    public function testValidationForCorrectValue(string $number)
    {
        $this->assertTrue(Identifikationsnummer::isNumberValid($number));
    }

    /**
     * @dataProvider incorrectValuesProvider
     * @param string $number
     */
    public function testIfCanNotCreateClassFromInvalidValue(string $number)
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Identifikationsnummer is invalid');
        $this->expectExceptionCode(422);

        new Identifikationsnummer($number);
    }

    public function incorrectValuesProvider()
    {
        return [
            ['not a numeric'],
            ['1234567890'], // only 10 digits
            ['98600376510'], // valid Identificationsnummer with replaced control number
        ];
    }

    public function correctValuesProvider()
    {
        return [
            ['98600376519'],
            ['24476800151'],
            ['79168525460']
        ];
    }
}
