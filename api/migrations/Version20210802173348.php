<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210802173348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE fields_types
            (
                id uuid NOT NULL,
                name varchar(50) NOT NULL,
                sort smallint NOT NULL,
                created_by uuid NOT NULL,
                updated_by uuid NOT NULL,
                created_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                updated_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY (id)
            )'
        );

        $this->addSql('CREATE INDEX IDX_F151BA46DE12AB56 ON fields_types (created_by)');
        $this->addSql('CREATE INDEX IDX_F151BA4616FE72E1 ON fields_types (updated_by)');
        $this->addSql('CREATE UNIQUE INDEX fields_types_name_uidx ON fields_types (LOWER(name))');

        $this->addSql('COMMENT ON COLUMN fields_types.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN fields_types.created_by IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN fields_types.updated_by IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN fields_types.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN fields_types.updated_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql(
            'ALTER TABLE fields_types
             ADD CONSTRAINT fk_f151ba46de12ab56
                FOREIGN KEY (created_by)
                    REFERENCES users (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );

        $this->addSql(
            'ALTER TABLE fields_types
             ADD CONSTRAINT fk_f151ba4616fe72e1
                FOREIGN KEY (updated_by)
                    REFERENCES users (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fields_types');
    }
}
