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

        static::assertSame($id, $user->id());
        static::assertSame($username, $user->username());
        static::assertSame($email, $user->email());
        static::assertSame($password, $user->password());
        static::assertSame($firstName, $user->firstName());
        static::assertSame($lastName, $user->lastName());
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

        static::assertSame($expectedPayload, json_encode($user));
    }
}
