<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260728041711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add DC2Type comment on complainant.personal_code so schema comparison recognizes the encrypted_personal_code custom type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('COMMENT ON COLUMN complainant.personal_code IS \'(DC2Type:encrypted_personal_code)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('COMMENT ON COLUMN complainant.personal_code IS NULL');
    }
}
