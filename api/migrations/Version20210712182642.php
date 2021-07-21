<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712182642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE cards
            (
                id uuid NOT NULL,
                created_by uuid NOT NULL,
                created_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY (id)
            )'
        );

        $this->addSql('CREATE INDEX idx_4c258fdde12ab56 ON cards (created_by)');

        $this->addSql('COMMENT ON COLUMN cards.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN cards.created_by IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN cards.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql(
            'ALTER TABLE cards
             ADD CONSTRAINT fk_4c258fdde12ab56
                FOREIGN KEY (created_by)
                    REFERENCES users (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE cards');
    }
}
