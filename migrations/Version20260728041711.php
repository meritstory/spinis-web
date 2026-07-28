<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260728041711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create complainant table, drop refresh_tokens table (gesdinet/jwt-refresh-token-bundle removed), and add DC2Type comment on complainant.personal_code so schema comparison recognizes the encrypted_personal_code custom type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE complainant (id SERIAL NOT NULL, legal_entity BOOLEAN NOT NULL, personal_code VARCHAR(255) NOT NULL, company_code VARCHAR(20) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(50) NOT NULL, address VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A647D432461F37A5 ON complainant (personal_code)');
        $this->addSql('DROP SEQUENCE refresh_tokens_id_seq CASCADE');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('COMMENT ON COLUMN complainant.personal_code IS \'(DC2Type:encrypted_personal_code)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('COMMENT ON COLUMN complainant.personal_code IS NULL');
        $this->addSql('CREATE SEQUENCE refresh_tokens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE refresh_tokens (id SERIAL NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BACE7E1C74F2195 ON refresh_tokens (refresh_token)');
        $this->addSql('DROP TABLE complainant');
    }
}
