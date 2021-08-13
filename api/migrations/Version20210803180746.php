<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803180746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE fields
            (
                id uuid NOT NULL,
                type_id uuid NOT NULL,
                title varchar(50) NOT NULL,
                bg_color varchar(7) NOT NULL,
                text_color varchar(7) NOT NULL,
                icon_path varchar(255),
                help varchar(500),
                created_by uuid NOT NULL,
                updated_by uuid NOT NULL,
                created_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                updated_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY (id)
            )'
        );

        $this->addSql('CREATE INDEX IDX_7EE5E388C54C8C93 ON fields (type_id)');
        $this->addSql('CREATE INDEX IDX_7EE5E388DE12AB56 ON fields (created_by)');
        $this->addSql('CREATE INDEX IDX_7EE5E38816FE72E1 ON fields (updated_by)');

        $this->addSql('COMMENT ON COLUMN fields.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN fields.type_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN fields.created_by IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN fields.updated_by IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN fields.bg_color IS \'(DC2Type:field_color)\'');
        $this->addSql('COMMENT ON COLUMN fields.text_color IS \'(DC2Type:field_color)\'');
        $this->addSql('COMMENT ON COLUMN fields.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN fields.updated_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql(
            'ALTER TABLE fields
             ADD CONSTRAINT fk_7ee5e388c54c8c93
                FOREIGN KEY (type_id)
                    REFERENCES fields_types (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );

        $this->addSql(
            'ALTER TABLE fields
             ADD CONSTRAINT fk_7ee5e388de12ab56
                FOREIGN KEY (created_by)
                    REFERENCES users (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );

        $this->addSql(
            'ALTER TABLE fields
             ADD CONSTRAINT fk_7ee5e38816fe72e1
                FOREIGN KEY (updated_by)
                    REFERENCES users (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fields');
    }
}
