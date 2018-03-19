<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:50
 */

namespace App\Repository;


use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;

class DoctrineUserRepository implements UserRepository
{

    public function store(User $user)
    {
        // TODO: Implement store() method.
    }

    /**
     * @return array|User[]
     */
    public function fetchAll(): array
    {
        return [];
    }
}