<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:36
 */

namespace App\Domain\Factory;


use App\Domain\Model\CountryCode;
use App\Domain\Model\Identity\Identifikationsnummer;
use App\Domain\Model\IdentityNumber;

class IdentificationsnummerFactory implements IdentityNumberFactory
{
    /**
     * Determines if the factory can create ID number for specified country
     *
     * @param CountryCode $countryCode
     * @return bool
     */
    public function fitsTo(CountryCode $countryCode): bool
    {
        return $countryCode->is(CountryCode::DE);
    }

    public function create(string $number): IdentityNumber
    {
        return new Identifikationsnummer($number);
    }
}