<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260728095308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE COLLATION lt_alphabet (
                provider = icu,
                locale = 'und',
                rules = '&a < ą <<< Ą &c < č <<< Č &e < ę <<< Ę < ė <<< Ė &i < į <<< Į < y <<< Y &s < š <<< Š &u < ų <<< Ų < ū <<< Ū &z < ž <<< Ž &ž < q <<< Q < w <<< W < x <<< X'
            )
            SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLLATION lt_alphabet IS
            'Lithuanian ABC order with ICU case folding (<<<). Applied on complainant name columns; not lt-LT-x-icu.'
            SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE complainant
                ALTER COLUMN first_name TYPE VARCHAR(100) COLLATE lt_alphabet,
                ALTER COLUMN last_name TYPE VARCHAR(100) COLLATE lt_alphabet
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE complainant
                ALTER COLUMN first_name TYPE VARCHAR(100) COLLATE pg_catalog."default",
                ALTER COLUMN last_name TYPE VARCHAR(100) COLLATE pg_catalog."default"
            SQL);
        $this->addSql('DROP COLLATION IF EXISTS lt_alphabet');
    }
}
