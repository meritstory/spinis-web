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
            CREATE FUNCTION lithuanian_sort_key(input TEXT)
            RETURNS BYTEA
            LANGUAGE plpgsql
            IMMUTABLE
            STRICT
            PARALLEL SAFE
            AS $$
            DECLARE
                alphabet CONSTANT TEXT := 'aąbcčdeęėfghiįyjklmnoprsštuųūvzž';
                normalized TEXT := normalize(lower(input), NFC);
                result BYTEA := '\x'::bytea;
                character TEXT;
                position SMALLINT;
                i INTEGER;
            BEGIN
                IF normalized = '' THEN
                    RETURN result;
                END IF;

                FOR i IN 1..char_length(normalized) LOOP
                    character := substr(normalized, i, 1);
                    position := strpos(alphabet, character);

                    IF position = 0 THEN
                        position := 32767;
                    END IF;

                    result := result || int2send(position);
                END LOOP;

                RETURN result;
            END;
            $$;
            SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON FUNCTION lithuanian_sort_key(TEXT) IS
            'Case-insensitive Lithuanian alphabet sort key: A, Ą, B, C, Č, ..., Z, Ž'
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP FUNCTION lithuanian_sort_key(TEXT)');
    }
}
