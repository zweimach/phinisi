<?php

declare(strict_types=1);

namespace App\Authors;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AuthorsRepository implements AuthorsService
{
    private EntityManager $em;

    /**
     * @var EntityRepository<Author>
     */
    private EntityRepository $database;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->database = $em->getRepository(Author::class);
    }

    /**
     * @return array<Author>
     */
    public function findAll(): array
    {
        $authors = $this->database->findBy([], null, 10);

        return $authors;
    }

    /**
     * @throws AuthorNotFoundException
     */
    public function findAuthorOfId(int $id): Author
    {
        $author = $this->database->find($id);
        if ($author === null) {
            throw new AuthorNotFoundException();
        }

        return $author;
    }

    public function createAuthor(string $firstName, string $lastName): int
    {
        $author = new Author(
            id: 0,
            firstName: $firstName,
            lastName: $lastName,
        );
        $this->em->persist($author);
        $this->em->flush();
        return $author->id();
    }
}
