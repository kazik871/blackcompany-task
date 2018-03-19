<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 20:44
 */

namespace App\Infrastructure\Entity;


use App\Domain\Factory\UserFactory;
use App\Domain\Model\CountryCode;
use App\Domain\Model\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class UserEntity
{
    /**
     * @ORM\Column(name="user_id")
     */
    private $id;
    /**
     * @ORM\Column(name="identification_number")
     */
    private $identificationNumber;
    /**
     * @ORM\Column(name="first_name")
     */
    private $firstName;
    /**
     * @ORM\Column(name="surname")
     */
    private $surname;
    /**
     * @ORM\Column(name="country_code")
     */
    private $countryCode;

    public static function fromDomainObject(User $user): UserEntity {
        $self = new self();

        $self->id = $user->userId();
        $self->identificationNumber = $user->identityNumber()->value();
        $self->firstName = $user->name()->firstName();
        $self->surname = $user->name()->surname();
        $self->countryCode = $user->countryCode()->getValue();

        return $self;
    }

    public function toDomainObject(UserFactory $factory): User {
        return $factory->createWithId(
            $this->id,
            $this->identificationNumber,
            CountryCode::get($this->countryCode),
            $this->firstName,
            $this->surname
        );
    }
}