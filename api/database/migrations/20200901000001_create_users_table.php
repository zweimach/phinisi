<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table
            ->addColumn('username', 'string', ['limit' => 30])
            ->addColumn('password', 'text')
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('first_name', 'string', ['limit' => 40])
            ->addColumn('last_name', 'string', ['limit' => 40])
            ->create();
    }
}
