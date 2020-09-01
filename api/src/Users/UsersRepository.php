<?php

declare(strict_types=1);

namespace App\Users;

use Medoo\Medoo;

class UsersRepository implements UsersService
{
    private const COLUMN = ['id', 'username', 'email', 'password', 'first_name', 'last_name'];

    private Medoo $database;

    public function __construct(Medoo $database)
    {
        $this->database = $database;
    }

    /**
     * @return array<User>
     */
    public function findAll(): array
    {
        $users = $this->database->select('users', self::COLUMN);
        if ($users === false) {
            $users = [];
        }

        return array_map(fn ($user) => User::of($user), $users);
    }

    /**
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User
    {
        $user = $this->database->get('users', self::COLUMN, ['id' => $id]);
        if (!isset($user)) {
            throw new UserNotFoundException();
        }

        return User::of($user);
    }
}
