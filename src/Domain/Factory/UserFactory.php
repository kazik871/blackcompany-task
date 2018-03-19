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
     * @var IdentityNumberFactory[]
     */
    private $identityNumberFactories;

    public function __construct(IdentityNumberFactory ...$identityNumberFactories)
    {
        $this->identityNumberFactories = $identityNumberFactories;
    }

    public function create(string $identityNumber, CountryCode $countryCode, string $firstName, string $surname): User
    {
        return $this->createWithId(Uuid::uuid4(), $identityNumber, $countryCode, $firstName, $surname);
    }

    public function createWithId(UuidInterface $identity, string $identityNumber, CountryCode $countryCode,
                                 string $firstName, string $surname): User
    {
        $identityNumberFactory = $this->resolveIdentityNumberFactoryStrategy($countryCode);
        $identityNumberObject = $identityNumberFactory->create($identityNumber);
        $name = new Name($firstName, $surname);

        return new User($identity, $identityNumberObject, $name, $countryCode);
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