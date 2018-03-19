<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 17:30
 */

namespace App\Domain\Model;

use Ramsey\Uuid\UuidInterface;

class User implements \JsonSerializable
{
    /**
     * @var UuidInterface
     */
    private $userId;
    /**
     * @var IdentityNumber
     */
    private $identityNumber;
    /**
     * @var Name
     */
    private $name;
    /**
     * @var CountryCode
     */
    private $countryCode;

    public function __construct(UuidInterface $identity, IdentityNumber $identityNumber,
                                Name $name, CountryCode $countryCode)
    {
        $this->userId = $identity;
        $this->identityNumber = $identityNumber;
        $this->name = $name;
        $this->countryCode = $countryCode;
    }

    public function userId()
    {
        return $this->userId;
    }

    public function identityNumber()
    {
        return $this->identityNumber;
    }

    public function name()
    {
        return $this->name;
    }

    public function countryCode()
    {
        return $this->countryCode;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->userId,
            'first_name' => $this->name->firstName(),
            'surname' => $this->name->surname(),
            'country_code' => $this->countryCode->getValue(),
            'identification_number' => $this->identityNumber->value()
        ];
    }
}