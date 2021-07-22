<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721190706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE profiles
            (
                id uuid NOT NULL,
                user_id uuid NOT NULL,
                user_card_id uuid DEFAULT NULL,
                title varchar(100) NOT NULL,
                photo_path varchar(255) DEFAULT NULL,
                name varchar(100) NOT NULL,
                nickname varchar(100) DEFAULT NULL,
                default_name smallint DEFAULT 1 NOT NULL,
                post varchar(100) DEFAULT NULL,
                description text DEFAULT NULL,
                is_published boolean DEFAULT \'false\' NOT NULL,
                created_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                updated_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY (id)
            )'
        );
        $this->addSql('CREATE INDEX IDX_8B308530A76ED395 ON profiles (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B30853012C1842A ON profiles (user_card_id)');
        $this->addSql('CREATE UNIQUE INDEX profile_user_id_user_card_id_uidx ON profiles (user_id, user_card_id)');

        $this->addSql('COMMENT ON COLUMN profiles.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN profiles.user_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN profiles.user_card_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN profiles.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN profiles.updated_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql(
            'ALTER TABLE profiles
             ADD CONSTRAINT fk_8b308530a76ed395
                FOREIGN KEY (user_id)
                    REFERENCES users (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );

        $this->addSql(
            'ALTER TABLE profiles
             ADD CONSTRAINT fk_8b30853012c1842a
                FOREIGN KEY (user_card_id)
                    REFERENCES user_cards (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE profiles');
    }
}
