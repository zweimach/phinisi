<?php

declare(strict_types=1);

namespace App\Authors;

use App\Shared\DomainRecordNotFoundException;

class AuthorNotFoundException extends DomainRecordNotFoundException
{
    /**
     * @var mixed
     */
    public $message = 'The author you requested does not exist.';
}
