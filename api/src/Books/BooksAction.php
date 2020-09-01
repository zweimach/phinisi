<?php

declare(strict_types=1);

namespace App\Books;

use App\Shared\Action;
use Psr\Log\LoggerInterface;

abstract class BooksAction extends Action
{
    protected BooksService $booksService;

    public function __construct(LoggerInterface $logger, BooksService $booksService)
    {
        parent::__construct($logger);
        $this->booksService = $booksService;
    }
}
