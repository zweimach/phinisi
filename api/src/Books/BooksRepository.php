<?php

declare(strict_types=1);

namespace App\Books;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class BooksRepository implements BooksService
{
    private EntityManager $em;

    /**
     * @var EntityRepository<Book>
     */
    private EntityRepository $database;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->database = $em->getRepository(Book::class);
    }

    /**
     * @return array<Book>
     */
    public function findAll(): array
    {
        $books = $this->database->findBy([], null, 10);

        return $books;
    }

    /**
     * @throws BookNotFoundException
     */
    public function findBookOfId(int $id): Book
    {
        $book = $this->database->find($id);
        if ($book === null) {
            throw new BookNotFoundException();
        }

        return $book;
    }
}
