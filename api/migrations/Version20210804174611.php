<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210804174611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE profiles_fields
            (
                id uuid NOT NULL,
                profile_id uuid NOT NULL,
                field_id uuid DEFAULT NULL,
                value varchar(255) NOT NULL,
                sort smallint DEFAULT 10 NOT NULL,
                PRIMARY KEY (id)
            )'
        );

        $this->addSql('CREATE INDEX idx_fab1ad8eccfa12b8 ON profiles_fields (profile_id)');
        $this->addSql('CREATE INDEX IDX_FAB1AD8E443707B0 ON profiles_fields (field_id)');

        $this->addSql('COMMENT ON COLUMN profiles_fields.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN profiles_fields.profile_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN profiles_fields.field_id IS \'(DC2Type:entity_id)\'');

        $this->addSql(
            'ALTER TABLE profiles_fields
             ADD CONSTRAINT fk_fab1ad8eccfa12b8
                FOREIGN KEY (profile_id)
                    REFERENCES profiles (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );

        $this->addSql(
            'ALTER TABLE profiles_fields
             ADD CONSTRAINT fk_fab1ad8e443707b0
                FOREIGN KEY (field_id)
                    REFERENCES fields (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profiles_fields');
    }
}
