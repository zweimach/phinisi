<?php

declare(strict_types=1);

namespace App\Books;

use App\Shared\DomainRecordNotFoundException;

class BookNotFoundException extends DomainRecordNotFoundException
{
    /**
     * @var mixed
     */
    public $message = 'The book you requested does not exist.';
}
