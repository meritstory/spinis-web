<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260728134522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE complaint (id SERIAL NOT NULL, number VARCHAR(50) NOT NULL, institution_name VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, status VARCHAR(50) NOT NULL, term_status VARCHAR(50) NOT NULL, specialist VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F2732B596901F54 ON complaint (number)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE complaint');
    }
}
