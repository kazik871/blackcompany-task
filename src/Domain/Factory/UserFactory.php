<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 20:46
 */

namespace App\Domain\Factory;


use App\Domain\Model\CountryCode;
use App\Domain\Model\Name;
use App\Domain\Model\User;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserFactory
{
    /**
     * @var IdentityNumberAbstractFactory
     */
    private $factory;

    public function __construct(IdentityNumberAbstractFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(string $identityNumber, CountryCode $countryCode, string $firstName, string $surname): User
    {
        return $this->createWithId(Uuid::uuid4(), $identityNumber, $countryCode, $firstName, $surname);
    }

    public function createWithId(UuidInterface $identity, string $identityNumber, CountryCode $countryCode,
                                 string $firstName, string $surname): User
    {
        $identityNumberObject = $this->factory->create($countryCode, $identityNumber);
        $name = new Name($firstName, $surname);

        return new User($identity, $identityNumberObject, $name, $countryCode);
    }
}