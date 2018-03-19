<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 17:32
 */

namespace App\Domain\Model;


interface IdentityNumber
{
    public function value(): string;
}