<?php

declare(strict_types=1);

namespace App\Authors;

interface AuthorsService
{
    /**
     * @return array<Author>
     */
    public function findAll(): array;

    /**
     * @throws AuthorNotFoundException
     */
    public function findAuthorOfId(int $id): Author;

    public function createAuthor(string $firstName, string $lastName): int;
}
