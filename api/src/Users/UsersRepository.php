<?php

declare(strict_types=1);

namespace App\Users;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class UsersRepository implements UsersService
{
    private EntityManager $em;

    /**
     * @var EntityRepository<User>
     */
    private EntityRepository $database;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->database = $em->getRepository(User::class);
    }

    /**
     * @return list<User>
     */
    public function findAll(): array
    {
        $users = $this->database->findBy([], null, 10);

        return $users;
    }

    /**
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User
    {
        $user = $this->database->find($id);
        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function createUser(string $username, string $email, string $password, string $firstName = '', string $lastName = ''): int
    {
        $user = new User(
            id: 0,
            username: $username,
            email: $email,
            password: $password,
            firstName: $firstName,
            lastName: $lastName,
        );
        $this->em->persist($user);
        $this->em->flush();
        return $user->id();
    }
}
