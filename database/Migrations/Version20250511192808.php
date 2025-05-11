<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511192808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE doctrine_migration_versions
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE modules ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP createdAt, DROP updatedAt
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE permissions ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP createdAt, DROP updatedAt
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP createdAt, DROP updatedAt
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users DROP createdAt, DROP updatedAt, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE doctrine_migration_versions (version VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, executed_at DATETIME DEFAULT NULL, execution_time INT DEFAULT NULL, PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE modules ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, DROP created_at, DROP updated_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, DROP created_at, DROP updated_at
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE permissions ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, DROP created_at, DROP updated_at
        SQL);
    }
}
