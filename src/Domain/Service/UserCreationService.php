<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:30
 */

namespace App\Domain\Service;


use App\Domain\Factory\IdentityNumberFactory;
use App\Domain\Model\CountryCode;
use App\Domain\Model\Name;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;
use Ramsey\Uuid\Uuid;

class UserCreationService
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var IdentityNumberFactory[]
     */
    private $identityNumberFactories;

    public function __construct(UserRepository $repository, IdentityNumberFactory ...$identityNumberFactories)
    {
        $this->repository = $repository;
        $this->identityNumberFactories = $identityNumberFactories;
    }

    public function create(string $identityNumber, CountryCode $countryCode, string $firstName, string $surname): User
    {
        $identityNumberFactory = $this->resolveIdentityNumberFactoryStrategy($countryCode);
        $identityNumberObject = $identityNumberFactory->create($identityNumber);
        $name = new Name($firstName, $surname);
        $userId = Uuid::uuid4();

        $user = new User($userId, $identityNumberObject, $name, $countryCode);
        $this->repository->store($user);
        return $user;
    }

    private function resolveIdentityNumberFactoryStrategy(CountryCode $countryCode): IdentityNumberFactory
    {
        foreach ($this->identityNumberFactories as $factory) {
            if ($factory->fitsTo($countryCode)) {
                return $factory;
            }
        }
        throw new \RuntimeException(
            sprintf('IdentityNumberFactory for given country code does not exist: %s', $countryCode->getValue())
        );
    }
}