<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260721083556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE stored_file (id UUID NOT NULL, uploaded_by_admin_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, file_size INT NOT NULL, mime_type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C339E77CA4B09E0F ON stored_file (uploaded_by_admin_id)');
        $this->addSql('COMMENT ON COLUMN stored_file.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE stored_file ADD CONSTRAINT FK_C339E77CA4B09E0F FOREIGN KEY (uploaded_by_admin_id) REFERENCES "admin" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE stored_file DROP CONSTRAINT FK_C339E77CA4B09E0F');
        $this->addSql('DROP TABLE stored_file');
    }
}
