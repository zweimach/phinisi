<?php

declare(strict_types=1);

namespace Tests\Users;

use App\Users\User;
use App\Users\UserNotFoundException;
use Tests\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    public function testFindAll(): void
    {
        $user = new User(1, 'bill.gates', 'bill@gates.com', 'billgates', 'Bill', 'Gates');

        $userRepository = new InMemoryUserRepository([1 => $user]);

        static::assertEquals([$user], $userRepository->findAll());
    }

    public function testFindAllUsersByDefault(): void
    {
        $users = [
            new User(1, 'bill.gates', 'bill@gates.com', 'billgates', 'Bill', 'Gates'),
            new User(2, 'steve.jobs', 'steve.jobs', 'stevejobs', 'Steve', 'Jobs'),
            new User(3, 'mark.zuckerberg', 'mark@zuckerberg.com', 'markzuckerberg', 'Mark', 'Zuckerberg'),
            new User(4, 'evan.spiegel', 'evan@spiegel.com', 'evanspiegel', 'Evan', 'Spiegel'),
            new User(5, 'jack.dorsey', 'jack@dorsey.com', 'jackdorsey', 'Jack', 'Dorsey'),
        ];

        $userRepository = new InMemoryUserRepository();

        static::assertEquals(array_values($users), $userRepository->findAll());
    }

    public function testFindUserOfId(): void
    {
        $user = new User(1, 'bill.gates', 'bill@gates.com', 'billgates', 'Bill', 'Gates');

        $userRepository = new InMemoryUserRepository([1 => $user]);

        static::assertEquals($user, $userRepository->findUserOfId(1));
    }

    public function testFindUserOfIdThrowsNotFoundException(): void
    {
        $userRepository = new InMemoryUserRepository([]);
        $this->expectException(UserNotFoundException::class);
        $userRepository->findUserOfId(1);
    }
}
