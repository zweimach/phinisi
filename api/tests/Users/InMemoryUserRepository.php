<?php

declare(strict_types=1);

namespace Tests\Users;

use App\Users\User;
use App\Users\UserNotFoundException;
use App\Users\UsersService;

class InMemoryUserRepository implements UsersService
{
    /**
     * @var array<User>
     */
    private array $users;

    /**
     * @param array<User>|null $users
     */
    public function __construct(?array $users = null)
    {
        $this->users = $users ?? [
            new User(1, 'bill.gates', 'bill@gates.com', 'billgates', 'Bill', 'Gates'),
            new User(2, 'steve.jobs', 'steve.jobs', 'stevejobs', 'Steve', 'Jobs'),
            new User(3, 'mark.zuckerberg', 'mark@zuckerberg.com', 'markzuckerberg', 'Mark', 'Zuckerberg'),
            new User(4, 'evan.spiegel', 'evan@spiegel.com', 'evanspiegel', 'Evan', 'Spiegel'),
            new User(5, 'jack.dorsey', 'jack@dorsey.com', 'jackdorsey', 'Jack', 'Dorsey'),
        ];
    }

    /**
     * @return array<User>
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User
    {
        if (! isset($this->users[$id])) {
            throw new UserNotFoundException();
        }

        return $this->users[$id];
    }
}
