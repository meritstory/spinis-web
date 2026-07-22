<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260715120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create document table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE document (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, document_key VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8698A76A6A25AE ON document (document_key)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE document');
    }
}
