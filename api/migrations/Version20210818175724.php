<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210818175724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE fields_custom
            (
                id uuid NOT NULL,
                user_id uuid NOT NULL,
                title varchar(50) NOT NULL,
                bg_color varchar(7) NOT NULL,
                text_color varchar(7) NOT NULL,
                icon_path varchar(255) DEFAULT NULL,
                created_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                updated_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY (id)
            )'
        );

        $this->addSql('CREATE INDEX IDX_4C4AA3A1A76ED395 ON fields_custom (user_id)');

        $this->addSql('COMMENT ON COLUMN fields_custom.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN fields_custom.user_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN fields_custom.bg_color IS \'(DC2Type:field_color)\'');
        $this->addSql('COMMENT ON COLUMN fields_custom.text_color IS \'(DC2Type:field_color)\'');
        $this->addSql('COMMENT ON COLUMN fields_custom.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN fields_custom.updated_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql(
            'ALTER TABLE fields_custom
             ADD CONSTRAINT fk_4c4aa3a1a76ed395
                FOREIGN KEY (user_id)
                    REFERENCES users (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fields_custom');
    }
}
