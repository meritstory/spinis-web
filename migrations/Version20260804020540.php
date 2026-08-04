<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260804020540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE complaint_attachment (id SERIAL NOT NULL, complaint_id INT NOT NULL, stored_file_id UUID NOT NULL, type VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3258A707EDAE188E ON complaint_attachment (complaint_id)');
        $this->addSql('CREATE INDEX IDX_3258A7077590B9E4 ON complaint_attachment (stored_file_id)');
        $this->addSql('COMMENT ON COLUMN complaint_attachment.stored_file_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE complaint_status_history (id SERIAL NOT NULL, complaint_id INT NOT NULL, status VARCHAR(50) NOT NULL, changed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_88EEBD69EDAE188E ON complaint_status_history (complaint_id)');
        $this->addSql('COMMENT ON COLUMN complaint_status_history.changed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE complaint_attachment ADD CONSTRAINT FK_3258A707EDAE188E FOREIGN KEY (complaint_id) REFERENCES complaint (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE complaint_attachment ADD CONSTRAINT FK_3258A7077590B9E4 FOREIGN KEY (stored_file_id) REFERENCES stored_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE complaint_status_history ADD CONSTRAINT FK_88EEBD69EDAE188E FOREIGN KEY (complaint_id) REFERENCES complaint (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE complaint ADD patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE complaint ADD representative_id INT DEFAULT NULL');
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
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B56B899279 FOREIGN KEY (patient_id) REFERENCES complainant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE complaint ADD CONSTRAINT FK_5F2732B5FC3FF006 FOREIGN KEY (representative_id) REFERENCES complainant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5F2732B56B899279 ON complaint (patient_id)');
        $this->addSql('CREATE INDEX IDX_5F2732B5FC3FF006 ON complaint (representative_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE complaint_attachment DROP CONSTRAINT FK_3258A707EDAE188E');
        $this->addSql('ALTER TABLE complaint_attachment DROP CONSTRAINT FK_3258A7077590B9E4');
        $this->addSql('ALTER TABLE complaint_status_history DROP CONSTRAINT FK_88EEBD69EDAE188E');
        $this->addSql('DROP TABLE complaint_attachment');
        $this->addSql('DROP TABLE complaint_status_history');
        $this->addSql('ALTER TABLE complaint DROP CONSTRAINT FK_5F2732B56B899279');
        $this->addSql('ALTER TABLE complaint DROP CONSTRAINT FK_5F2732B5FC3FF006');
        $this->addSql('DROP INDEX IDX_5F2732B56B899279');
        $this->addSql('DROP INDEX IDX_5F2732B5FC3FF006');
        $this->addSql('ALTER TABLE complaint DROP patient_id');
        $this->addSql('ALTER TABLE complaint DROP representative_id');
        $this->addSql('ALTER TABLE complaint DROP term_date');
        $this->addSql('ALTER TABLE complaint DROP complaint_date');
        $this->addSql('ALTER TABLE complaint DROP event_date');
        $this->addSql('ALTER TABLE complaint DROP related_specialists');
        $this->addSql('ALTER TABLE complaint DROP complaint_description');
        $this->addSql('ALTER TABLE complaint DROP disagreement_description');
        $this->addSql('ALTER TABLE complaint DROP expected_result');
        $this->addSql('ALTER TABLE complaint DROP submitted_by_representative');
    }
}
