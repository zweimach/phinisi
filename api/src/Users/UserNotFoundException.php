<?php

declare(strict_types=1);

namespace App\Users;

use App\Shared\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    /**
     * @var string
     */
    public $message = 'The user you requested does not exist.';
}
