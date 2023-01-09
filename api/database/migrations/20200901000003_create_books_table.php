<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBooksTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('books');
        $table
            ->addColumn('title', 'string', [
                'limit' => 100,
            ])
            ->addColumn('description', 'text')
            ->addColumn('publication_date', 'date')
            ->addColumn('author_id', 'integer', [
                'null' => true,
            ])
            ->addForeignKey('author_id', 'authors')
            ->create();
    }
}
