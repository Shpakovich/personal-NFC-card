<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819184537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE profiles_fields_custom
            (
                id uuid NOT NULL,
                profile_id uuid NOT NULL,
                field_id uuid DEFAULT NULL,
                value varchar(255) NOT NULL,
                sort smallint DEFAULT 10 NOT NULL,
                PRIMARY KEY (id)
            )'
        );
        $this->addSql('CREATE INDEX IDX_B560B5E0CCFA12B8 ON profiles_fields_custom (profile_id)');
        $this->addSql('CREATE INDEX IDX_B560B5E0443707B0 ON profiles_fields_custom (field_id)');

        $this->addSql('COMMENT ON COLUMN profiles_fields_custom.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN profiles_fields_custom.profile_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN profiles_fields_custom.field_id IS \'(DC2Type:entity_id)\'');

        $this->addSql(
            'ALTER TABLE profiles_fields_custom
             ADD CONSTRAINT fk_b560b5e0ccfa12b8
                FOREIGN KEY (profile_id)
                    REFERENCES profiles (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );

        $this->addSql(
            'ALTER TABLE profiles_fields_custom
             ADD CONSTRAINT fk_b560b5e0443707b0
                FOREIGN KEY (field_id)
                    REFERENCES fields_custom (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profiles_fields_custom');
    }
}
