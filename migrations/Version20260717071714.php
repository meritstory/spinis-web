<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260717071714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create complainant table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE complainant (id SERIAL NOT NULL, legal_entity BOOLEAN NOT NULL, personal_code VARCHAR(255) NOT NULL, company_code VARCHAR(20) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(50) NOT NULL, address VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A647D432461F37A5 ON complainant (personal_code)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE complainant');
    }
}
