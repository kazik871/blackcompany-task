<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 17:34
 */

namespace App\Domain\Model;


final class Name
{
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $surname;

    public function __construct(string $firstName, string $surname)
    {
        $this->firstName = $firstName;
        $this->surname = $surname;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function surname(): string
    {
        return $this->surname;
    }
}