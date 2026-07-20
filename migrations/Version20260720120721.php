<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260720120721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER SEQUENCE user_id_seq RENAME TO admin_id_seq');
        $this->addSql('CREATE TABLE admin_invitation (id SERIAL NOT NULL, admin_id INT NOT NULL, token_hash VARCHAR(64) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3923C727642B8210 ON admin_invitation (admin_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3923C727B3BC57DA ON admin_invitation (token_hash)');
        $this->addSql('COMMENT ON COLUMN admin_invitation.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_invitation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE admin_invitation ADD CONSTRAINT FK_3923C727642B8210 FOREIGN KEY (admin_id) REFERENCES "admin" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin ADD email_two_factor_enabled BOOLEAN DEFAULT true NOT NULL');
        $this->addSql('ALTER TABLE admin ADD deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE admin ALTER first_name DROP DEFAULT');
        $this->addSql('ALTER TABLE admin ALTER last_name DROP DEFAULT');
        $this->addSql('ALTER TABLE admin ALTER roles TYPE JSONB USING roles::jsonb');
        $this->addSql('COMMENT ON COLUMN admin.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER INDEX uniq_d8698a76a6a25ae RENAME TO UNIQ_D8698A76593A594D');
        $this->addSql('ALTER INDEX uniq_36ac99f1e5beaf45 RENAME TO UNIQ_36AC99F1C6EB2692');
        $this->addSql('ALTER INDEX uniq_9f74b8986a6a25ae RENAME TO UNIQ_9F74B8985FA1E697');
        $this->addSql('DROP INDEX idx_75ea56e016ba31db');
        $this->addSql('DROP INDEX idx_75ea56e0e3bd61ce');
        $this->addSql('DROP INDEX idx_75ea56e0fb7336f0');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER SEQUENCE admin_id_seq RENAME TO user_id_seq');
        $this->addSql('ALTER TABLE admin_invitation DROP CONSTRAINT FK_3923C727642B8210');
        $this->addSql('DROP TABLE admin_invitation');
        $this->addSql('ALTER TABLE "admin" DROP email_two_factor_enabled');
        $this->addSql('ALTER TABLE "admin" DROP deleted_at');
        $this->addSql('ALTER TABLE "admin" ALTER first_name SET DEFAULT \'\'');
        $this->addSql('ALTER TABLE "admin" ALTER last_name SET DEFAULT \'\'');
        $this->addSql('ALTER TABLE "admin" ALTER roles TYPE JSON USING roles::json');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750');
        $this->addSql('CREATE INDEX idx_75ea56e016ba31db ON messenger_messages (delivered_at)');
        $this->addSql('CREATE INDEX idx_75ea56e0e3bd61ce ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX idx_75ea56e0fb7336f0 ON messenger_messages (queue_name)');
        $this->addSql('ALTER INDEX uniq_d8698a76593a594d RENAME TO uniq_d8698a76a6a25ae');
        $this->addSql('ALTER INDEX uniq_36ac99f1c6eb2692 RENAME TO uniq_36ac99f1e5beaf45');
        $this->addSql('ALTER INDEX uniq_9f74b8985fa1e697 RENAME TO uniq_9f74b8986a6a25ae');
    }
}
