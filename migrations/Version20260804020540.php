<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260804020540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add complaint edit page data, complaint patient, status history, and stored file relations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE complaint_patient (id SERIAL NOT NULL, complaint_id INT NOT NULL, user_id INT DEFAULT NULL, first_name VARCHAR(100) DEFAULT NULL COLLATE "lt_alphabet", last_name VARCHAR(100) DEFAULT NULL COLLATE "lt_alphabet", personal_code VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6F9237BAEDAE188E ON complaint_patient (complaint_id)');
        $this->addSql('CREATE INDEX IDX_6F9237BAA76ED395 ON complaint_patient (user_id)');
        $this->addSql('COMMENT ON COLUMN complaint_patient.personal_code IS \'(DC2Type:encrypted_personal_code)\'');
        $this->addSql('CREATE TABLE complaint_status_history (id SERIAL NOT NULL, complaint_id INT NOT NULL, status VARCHAR(50) NOT NULL, changed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_88EEBD69EDAE188E ON complaint_status_history (complaint_id)');
        $this->addSql('COMMENT ON COLUMN complaint_status_history.changed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE complaint_patient ADD CONSTRAINT FK_6F9237BAEDAE188E FOREIGN KEY (complaint_id) REFERENCES complaint (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE complaint_patient ADD CONSTRAINT FK_6F9237BAA76ED395 FOREIGN KEY (user_id) REFERENCES complainant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE complaint_status_history ADD CONSTRAINT FK_88EEBD69EDAE188E FOREIGN KEY (complaint_id) REFERENCES complaint (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE complaint ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD term_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD complaint_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD event_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD related_specialists TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD complaint_description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD disagreement_description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD expected_result TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD submitted_by_representative BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('COMMENT ON COLUMN complaint.term_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN complaint.complaint_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN complaint.event_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B5A76ED395 FOREIGN KEY (user_id) REFERENCES complainant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5F2732B5A76ED395 ON complaint (user_id)');
        $this->addSql('ALTER TABLE stored_file ADD complaint_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stored_file ADD type VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE stored_file ADD CONSTRAINT FK_C339E77CEDAE188E FOREIGN KEY (complaint_id) REFERENCES complaint (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C339E77CEDAE188E ON stored_file (complaint_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE complaint_patient DROP CONSTRAINT FK_6F9237BAEDAE188E');
        $this->addSql('ALTER TABLE complaint_patient DROP CONSTRAINT FK_6F9237BAA76ED395');
        $this->addSql('ALTER TABLE complaint_status_history DROP CONSTRAINT FK_88EEBD69EDAE188E');
        $this->addSql('DROP TABLE complaint_patient');
        $this->addSql('DROP TABLE complaint_status_history');
        $this->addSql('ALTER TABLE complaint DROP CONSTRAINT FK_5F2732B5A76ED395');
        $this->addSql('DROP INDEX IDX_5F2732B5A76ED395');
        $this->addSql('ALTER TABLE complaint DROP user_id');
        $this->addSql('ALTER TABLE complaint DROP term_date');
        $this->addSql('ALTER TABLE complaint DROP complaint_date');
        $this->addSql('ALTER TABLE complaint DROP event_date');
        $this->addSql('ALTER TABLE complaint DROP related_specialists');
        $this->addSql('ALTER TABLE complaint DROP complaint_description');
        $this->addSql('ALTER TABLE complaint DROP disagreement_description');
        $this->addSql('ALTER TABLE complaint DROP expected_result');
        $this->addSql('ALTER TABLE complaint DROP submitted_by_representative');
        $this->addSql('ALTER TABLE stored_file DROP CONSTRAINT FK_C339E77CEDAE188E');
        $this->addSql('DROP INDEX IDX_C339E77CEDAE188E');
        $this->addSql('ALTER TABLE stored_file DROP complaint_id');
        $this->addSql('ALTER TABLE stored_file DROP type');
    }
}
