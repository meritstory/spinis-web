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
                rules = '&a < ą < b < c < č < d < e < ę < ė < f < g < h < i < į < y < j < k < l < m < n < o < p < r < s < š < t < u < ų < ū < v < z < ž'
            )
            SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLLATION lt_alphabet IS
            'ICU collation: Lithuanian ABC order (A, Ą, B, C, Č, …, Z, Ž). Use with lower(normalize(col, NFC)) in queries; not the same as lt-LT-x-icu.'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP COLLATION IF EXISTS lt_alphabet');
    }
}
