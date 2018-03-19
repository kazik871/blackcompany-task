<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:33
 */

namespace App\Domain\Factory;


use App\Domain\Model\CountryCode;
use App\Domain\Model\IdentityNumber;

interface IdentityNumberFactory
{
    /**
     * Determines if the factory can create ID number for specified country
     *
     * @param CountryCode $countryCode
     * @return bool
     */
    public function fitsTo(CountryCode $countryCode): bool;

    public function create(string $number): IdentityNumber;
}