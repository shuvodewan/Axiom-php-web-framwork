<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511192942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE modules (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE permissions (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, module_id INT DEFAULT NULL, INDEX IDX_2DEDCC6FAFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, deleteable TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE permission_role (role_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_6A711CAD60322AC (role_id), INDEX IDX_6A711CAFED90CCA (permission_id), PRIMARY KEY(role_id, permission_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, user_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_verified_at DATETIME DEFAULT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(100) DEFAULT NULL, avatar VARCHAR(2048) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E924A232CF (user_name), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE permissions ADD CONSTRAINT FK_2DEDCC6FAFC2B591 FOREIGN KEY (module_id) REFERENCES modules (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE permission_role ADD CONSTRAINT FK_6A711CAD60322AC FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE permission_role ADD CONSTRAINT FK_6A711CAFED90CCA FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE permissions DROP FOREIGN KEY FK_2DEDCC6FAFC2B591
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE permission_role DROP FOREIGN KEY FK_6A711CAD60322AC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE permission_role DROP FOREIGN KEY FK_6A711CAFED90CCA
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE modules
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE permissions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE roles
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE permission_role
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users
        SQL);
    }
}
