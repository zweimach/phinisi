<?php

declare(strict_types=1);

namespace App\Authors;

use Medoo\Medoo;

class AuthorsRepository implements AuthorsService
{
    private const COLUMN = ['id', 'first_name', 'last_name'];

    private Medoo $database;

    public function __construct(Medoo $database)
    {
        $this->database = $database;
    }

    /**
     * @return array<Author>
     */
    public function findAll(): array
    {
        $authors = $this->database->select('authors', self::COLUMN);
        if ($authors === false) {
            $authors = [];
        }

        return array_map(fn ($author) => Author::of($author), $authors);
    }

    /**
     * @throws AuthorNotFoundException
     */
    public function findAuthorOfId(int $id): Author
    {
        $author = $this->database->get('authors', self::COLUMN, ['id' => $id]);
        if (!isset($author)) {
            throw new AuthorNotFoundException();
        }

        return Author::of($author);
    }
}
