<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:54
 */

namespace App\Tests\Domain\Service;

use App\Domain\Factory\IdentityNumberAbstractFactory;
use App\Domain\Factory\UserFactory;
use App\Domain\Model\CountryCode;
use App\Domain\Model\IdentityNumber;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Service\UserCreationService;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserCreationServiceTest extends TestCase
{
    /**
     * @var IdentityNumberAbstractFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $identityNumberFactory;
    /**
     * @var UserFactory
     */
    private $userFactory;
    /**
     * @var UserRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $userRepository;
    /**
     * @var UserCreationService
     */
    private $service;

    protected function setUp()
    {
        $this->identityNumberFactory = $this->getMockBuilder(IdentityNumberAbstractFactory::class)->getMock();
        $this->identityNumberFactory->method('fitsTo')->willReturn(true);
        $this->identityNumberFactory->method('create')->willReturnCallback(
            function (string $number) {
                return new class ($number) implements IdentityNumber
                {
                    /**
                     * @var string
                     */
                    private $number;

                    public function __construct(string $number)
                    {
                        $this->number = $number;
                    }

                    public function value(): string
                    {
                        return $this->number;
                    }
                };
            }
        );

        $this->userFactory = new UserFactory($this->identityNumberFactory);

        $this->userRepository = $this->getMockBuilder(UserRepository::class)->getMock();

        $this->service = new UserCreationService($this->userRepository, $this->userFactory);
    }

    public function testIfCreatesUser()
    {
        $number = '12345678901';
        $country = CountryCode::get(CountryCode::PL);
        $firstName = 'John';
        $surname = 'Doe';

        $this->userRepository->expects($this->once())->method('store')->with($this->callback(
            function (User $user) use ($number, $country, $firstName, $surname) {
                return Uuid::isValid($user->userId()->toString())
                    && $user->identityNumber()->value() === $number
                    && $user->countryCode()->is($country)
                    && $user->name()->firstName() === $firstName
                    && $user->name()->surname() === $surname;
            }
        ));

        $user = $this->service->create($number, $country, $firstName, $surname);

        $this->assertTrue(Uuid::isValid($user->userId()->toString()));
        $this->assertSame($user->identityNumber()->value(), $number);
        $this->assertSame($user->countryCode(), $country);
        $this->assertSame($user->name()->firstName(), $firstName);
        $this->assertSame($user->name()->surname(), $surname);
    }
}
