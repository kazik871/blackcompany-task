<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:35
 */

namespace App\Domain\Factory;


use App\Domain\Model\CountryCode;
use App\Domain\Model\Identity\Pesel;
use App\Domain\Model\IdentityNumber;

class PeselFactory implements IdentityNumberFactory
{
    /**
     * Determines if the factory can create ID number for specified country
     *
     * @param CountryCode $countryCode
     * @return bool
     */
    public function fitsTo(CountryCode $countryCode): bool
    {
        return $countryCode->is(CountryCode::PL);
    }

    public function create(string $number): IdentityNumber
    {
        return new Pesel($number);
    }
}