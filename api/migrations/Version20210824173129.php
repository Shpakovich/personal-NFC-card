<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824173129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE favorites
            (
                id uuid NOT NULL,
                user_id uuid NOT NULL,
                profile_id uuid NOT NULL,
                PRIMARY KEY (id)
            )'
        );
        $this->addSql('CREATE INDEX IDX_E46960F5A76ED395 ON favorites (user_id)');
        $this->addSql('CREATE INDEX IDX_E46960F5CCFA12B8 ON favorites (profile_id)');
        $this->addSql('CREATE UNIQUE INDEX favorites_user_id_profile_id_uidx ON favorites (user_id, profile_id)');

        $this->addSql('COMMENT ON COLUMN favorites.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN favorites.user_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN favorites.profile_id IS \'(DC2Type:entity_id)\'');

        $this->addSql(
            'ALTER TABLE favorites
             ADD CONSTRAINT fk_e46960f5a76ed395
                FOREIGN KEY (user_id)
                    REFERENCES users (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );

        $this->addSql(
            'ALTER TABLE favorites
             ADD CONSTRAINT fk_e46960f5ccfa12b8
                FOREIGN KEY (profile_id)
                    REFERENCES profiles (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE favorites');
    }
}
