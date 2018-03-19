<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:08
 */

namespace App\Domain\Model\Identity;


use App\Domain\Model\IdentityNumber;

final class Identifikationsnummer implements IdentityNumber
{
    /**
     * @var string
     */
    private $number;

    public function __construct(string $number)
    {
        if (!static::isNumberValid($number)) {
            throw new \DomainException('Identifikationsnummer is invalid', 422);
        }
        $this->number = $number;
    }

    public function value(): string
    {
        return $this->number;
    }

    public static function isNumberValid(string $number): bool
    {
        if (strlen($number) !== 11 || !is_numeric($number)) {
            return false;
        }

        $digits = array_map(function (string $char) {
            // maybe not necessary, but for the sake of static typing
            return (int)$char;
        }, str_split($number));

        $product = 0;
        for ($i = 0; $i < 10; ++$i) {
            $sum = ($digits[$i] + $product) % 10;
            if ($sum === 0) {
                $sum = 10;
            }
            $product = ($sum * 2) % 11;
        }

        $computedControlNumber = 11 - $product;
        if ($computedControlNumber == 10) {
            $computedControlNumber = 0;
        }

        return $computedControlNumber === $digits[10];
    }
}