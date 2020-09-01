<?php

declare(strict_types=1);

namespace App\Users;

use JsonSerializable;

class User implements JsonSerializable
{
    private int $id;

    private string $username;

    private string $email;

    private string $password;

    private string $firstName;

    private string $lastName;

    /**
     * @param int|string $id
     */
    public function __construct(
        $id,
        string $username,
        string $email,
        string $password,
        string $firstName,
        string $lastName
    ) {
        $this->id = (int) $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }

    /**
     * @param array<string> $user
     */
    public static function of(array $user): self
    {
        $id = $user['id'];
        $username = $user['username'];
        $email = $user['email'];
        $password = $user['password'];
        $firstName = $user['first_name'];
        $lastName = $user['last_name'];

        return new self($id, $username, $email, $password, $firstName, $lastName);
    }
}
