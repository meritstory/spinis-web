<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260708120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "admin" ADD first_name VARCHAR(255) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE "admin" ADD last_name VARCHAR(255) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE "admin" ADD email VARCHAR(180) DEFAULT NULL');
        $this->addSql('UPDATE "admin" SET email = username');
        $this->addSql('ALTER TABLE "admin" ALTER COLUMN email SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON "admin" (email)');
        $this->addSql('ALTER TABLE "admin" ADD active BOOLEAN DEFAULT true NOT NULL');
        $this->addSql('ALTER TABLE "admin" ADD last_active_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE "admin" ADD auth_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "admin" ADD auth_code_expires_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN "admin".last_active_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "admin".auth_code_expires_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('ALTER TABLE "admin" DROP username');

        $this->addSql('CREATE TABLE reset_password_request (id SERIAL NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "admin" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE "admin" ADD username VARCHAR(180) DEFAULT NULL');
        $this->addSql('UPDATE "admin" SET username = email');
        $this->addSql('ALTER TABLE "admin" ALTER COLUMN username SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "admin" (username)');
        $this->addSql('ALTER TABLE "admin" DROP auth_code_expires_at');
        $this->addSql('ALTER TABLE "admin" DROP auth_code');
        $this->addSql('ALTER TABLE "admin" DROP last_active_at');
        $this->addSql('ALTER TABLE "admin" DROP active');
        $this->addSql('DROP INDEX UNIQ_880E0D76E7927C74');
        $this->addSql('ALTER TABLE "admin" DROP email');
        $this->addSql('ALTER TABLE "admin" DROP last_name');
        $this->addSql('ALTER TABLE "admin" DROP first_name');
    }
}
