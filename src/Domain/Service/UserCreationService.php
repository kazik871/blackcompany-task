<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:30
 */

namespace App\Domain\Service;


use App\Domain\Factory\UserFactory;
use App\Domain\Model\CountryCode;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;

class UserCreationService
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var UserFactory
     */
    private $factory;

    public function __construct(UserRepository $repository, UserFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function create(string $identityNumber, CountryCode $countryCode, string $firstName, string $surname): User
    {
        $user = $this->factory->create($identityNumber, $countryCode, $firstName, $surname);
        $this->repository->store($user);
        return $user;
    }
}