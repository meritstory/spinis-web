<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260714070000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create link table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE link (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, link_key VARCHAR(255) NOT NULL, url VARCHAR(2048) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_36AC99F1E5BEAF45 ON link (link_key)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE link');
    }
}
