<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateAuthorsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('authors');
        $table
            ->addColumn('first_name', 'string', [
                'limit' => 40,
            ])
            ->addColumn('last_name', 'string', [
                'limit' => 40,
            ])
            ->create();
    }
}
