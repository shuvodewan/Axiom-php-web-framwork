<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250512124759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates messenger_messages table for Symfony Messenger';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('messenger_messages');
        
        $table->addColumn('id', 'bigint', [
            'autoincrement' => true,
            'notnull' => true,
        ]);
        $table->addColumn('body', 'text', [
            'notnull' => true,
        ]);
        $table->addColumn('headers', 'text', [
            'notnull' => true,
        ]);
        $table->addColumn('queue_name', 'string', [
            'length' => 190,
            'notnull' => true,
        ]);
        $table->addColumn('created_at', 'datetime', [
            'notnull' => true,
        ]);
        $table->addColumn('available_at', 'datetime', [
            'notnull' => true,
        ]);
        $table->addColumn('delivered_at', 'datetime', [
            'notnull' => false,
        ]);
        
        $table->setPrimaryKey(['id']);
        $table->addIndex(['queue_name']);
        $table->addIndex(['available_at']);
        $table->addIndex(['delivered_at']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('messenger_messages');
    }
}