<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:01
 */

namespace App\Tests\Domain\Model\Identity;

use App\Domain\Model\Identity\Pesel;
use PHPUnit\Framework\TestCase;

class PeselTest extends TestCase
{
    /**
     * @dataProvider incorrectValuesProvider
     * @param string $number
     */
    public function testValidationForIncorrectValue(string $number)
    {
        $this->assertFalse(Pesel::isNumberValid($number));
    }

    /**
     * @dataProvider correctValuesProvider
     * @param string $number
     */
    public function testValidationForCorrectValue(string $number)
    {
        $this->assertTrue(Pesel::isNumberValid($number));
    }

    /**
     * @dataProvider incorrectValuesProvider
     * @param string $number
     */
    public function testIfCanNotCreateClassFromInvalidValue(string $number)
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('PESEL is invalid');
        $this->expectExceptionCode(422);

        new Pesel($number);
    }

    public function incorrectValuesProvider()
    {
        return [
            ['not a numeric'],
            ['1234567890'], // only 10 digits
            ['80071104456'], // valid PESEL with replaced control number
        ];
    }

    public function correctValuesProvider()
    {
        return [
            ['80071104450'],
            ['97103118541']
        ];
    }
}
