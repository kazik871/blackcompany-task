<?php
/**
 * Created by PhpStorm.
 * User: piotrmacha
 * Date: 19/03/2018
 * Time: 18:50
 */

namespace App\Infrastructure\Repository;


use App\Domain\Factory\UserFactory;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;
use App\Infrastructure\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserFactory
     */
    private $factory;

    public function __construct(EntityManagerInterface $entityManager, UserFactory $factory)
    {
        $this->entityManager = $entityManager;
        $this->factory = $factory;
    }

    public function store(User $user)
    {
        $this->entityManager->persist(UserEntity::fromDomainObject($user));
        $this->entityManager->flush();
    }

    /**
     * @return array|User[]
     */
    public function fetchAll(): array
    {
        return [];
    }
}