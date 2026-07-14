<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260712045019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create faq table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE faq (id SERIAL NOT NULL, question VARCHAR(255) NOT NULL, answer TEXT NOT NULL, position INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8FF75CC462CE4F5 ON faq (position)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE faq');
    }
}
