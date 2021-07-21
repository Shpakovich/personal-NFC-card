<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210718164309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE user_cards
            (
                id uuid NOT NULL,
                user_id uuid NOT NULL,
                card_id uuid NOT NULL,
                alias varchar(100) DEFAULT NULL,
                added_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY (id)
            )'
        );

        $this->addSql('CREATE INDEX IDX_E600A3A5A76ED395 ON user_cards (user_id)');
        $this->addSql('CREATE UNIQUE INDEX user_cards_card_id_uidx ON user_cards (card_id)');
        $this->addSql('CREATE UNIQUE INDEX user_cards_alias_uidx ON user_cards (alias)');

        $this->addSql('COMMENT ON COLUMN user_cards.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN user_cards.user_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN user_cards.card_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN user_cards.added_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql(
            'ALTER TABLE user_cards
             ADD CONSTRAINT fk_e600a3a5a76ed395
                FOREIGN KEY (user_id)
                    REFERENCES users (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql(
            'ALTER TABLE user_cards
             ADD CONSTRAINT fk_e600a3a54acc9a20
                FOREIGN KEY (card_id)
                    REFERENCES cards (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_cards');
    }
}
