<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 20/03/2018
 * Time: 17:29
 */

namespace App\Form\User;


class UserDto
{
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $surname;
    /**
     * @var string
     */
    private $countryCode;
    /**
     * @var string
     */
    private $identificationNumber;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getIdentificationNumber()
    {
        return $this->identificationNumber;
    }

    /**
     * @param string $identificationNumber
     */
    public function setIdentificationNumber(string $identificationNumber): void
    {
        $this->identificationNumber = $identificationNumber;
    }
}