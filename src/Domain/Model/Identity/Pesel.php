<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 17:46
 */

namespace App\Domain\Model\Identity;


use App\Domain\Model\IdentityNumber;

final class Pesel implements IdentityNumber
{
    /**
     * @var int|string
     */
    private $number;

    public function __construct(string $number)
    {
        if (!static::isNumberValid($number)) {
            throw new \DomainException('PESEL is invalid', 422);
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

        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $sum = 0;
        for ($i = 0; $i < count($weights); ++$i) {
            $sum += $digits[$i] * $weights[$i];
        }

        $computedControlNumber = (10 - ($sum % 10)) % 10;

        return $computedControlNumber === $digits[10];
    }
}