<?php

declare(strict_types=1);

namespace Tests\Users;

use App\Users\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @return array<mixed>
     */
    public function userProvider(): array
    {
        return [
            [1, 'bill.gates', 'bill@gates.com', 'billgates', 'Bill', 'Gates'],
            [2, 'steve.jobs', 'steve.jobs', 'stevejobs', 'Steve', 'Jobs'],
            [3, 'mark.zuckerberg', 'mark@zuckerberg.com', 'markzuckerberg', 'Mark', 'Zuckerberg'],
            [4, 'evan.spiegel', 'evan@spiegel.com', 'evanspiegel', 'Evan', 'Spiegel'],
            [5, 'jack.dorsey', 'jack@dorsey.com', 'jackdorsey', 'Jack', 'Dorsey'],
        ];
    }

    /**
     * @dataProvider userProvider
     */
    public function testGetters(
        int $id,
        string $username,
        string $email,
        string $password,
        string $firstName,
        string $lastName
    ): void {
        $user = new User($id, $username, $email, $password, $firstName, $lastName);

        static::assertEquals($id, $user->id());
        static::assertEquals($username, $user->username());
        static::assertEquals($email, $user->email());
        static::assertEquals($password, $user->password());
        static::assertEquals($firstName, $user->firstName());
        static::assertEquals($lastName, $user->lastName());
    }

    /**
     * @dataProvider userProvider
     */
    public function testJsonSerialize(
        int $id,
        string $username,
        string $email,
        string $password,
        string $firstName,
        string $lastName
    ): void {
        $user = new User($id, $username, $email, $password, $firstName, $lastName);

        $expectedPayload = json_encode([
            'id' => $id,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);

        static::assertEquals($expectedPayload, json_encode($user));
    }
}
