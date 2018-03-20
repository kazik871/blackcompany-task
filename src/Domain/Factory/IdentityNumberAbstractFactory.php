<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:33
 */

namespace App\Domain\Factory;


use App\Domain\Model\CountryCode;
use App\Domain\Model\Identity\Identifikationsnummer;
use App\Domain\Model\Identity\Pesel;
use App\Domain\Model\IdentityNumber;

class IdentityNumberAbstractFactory
{
    public function create(CountryCode $countryCode, string $number): IdentityNumber
    {
        switch ($countryCode->getValue()) {
            case CountryCode::PL:
                return new Pesel($number);
                break;
            case CountryCode::DE:
                return new Identifikationsnummer($number);
                break;
            default:
                throw new \RuntimeException(
                    sprintf('Can not determine factory for given country code: %s', $countryCode->getValue())
                );
        }
    }
}