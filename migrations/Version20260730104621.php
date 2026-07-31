<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260730104621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE complaint (id SERIAL NOT NULL, health_care_institution_id INT NOT NULL, specialist_id INT DEFAULT NULL, number VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, status VARCHAR(50) NOT NULL, term_status VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F2732B5CADEC4DE ON complaint (health_care_institution_id)');
        $this->addSql('CREATE INDEX IDX_5F2732B57B100C1A ON complaint (specialist_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F2732B596901F54 ON complaint (number)');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B5CADEC4DE FOREIGN KEY (health_care_institution_id) REFERENCES health_care_institution (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B57B100C1A FOREIGN KEY (specialist_id) REFERENCES "admin" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE complaint DROP CONSTRAINT FK_5F2732B5CADEC4DE');
        $this->addSql('ALTER TABLE complaint DROP CONSTRAINT FK_5F2732B57B100C1A');
        $this->addSql('DROP TABLE complaint');
    }
}
