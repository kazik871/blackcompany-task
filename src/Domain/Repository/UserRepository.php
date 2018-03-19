<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:29
 */

namespace App\Domain\Repository;


use App\Domain\Model\User;

interface UserRepository
{
    public function store(User $user);

    /**
     * @return array|User[]
     */
    public function fetchAll(): array;
}