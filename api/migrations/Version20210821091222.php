<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210821091222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE metrics_views
            (
                id uuid NOT NULL,
                user_card_id uuid NOT NULL,
                profile_id uuid NOT NULL,
                created_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                PRIMARY KEY (id)
            )'
        );

        $this->addSql('CREATE INDEX IDX_133318C712C1842A ON metrics_views (user_card_id)');
        $this->addSql('CREATE INDEX IDX_133318C7CCFA12B8 ON metrics_views (profile_id)');

        $this->addSql('COMMENT ON COLUMN metrics_views.id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN metrics_views.user_card_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN metrics_views.profile_id IS \'(DC2Type:entity_id)\'');
        $this->addSql('COMMENT ON COLUMN metrics_views.created_at IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql(
            'ALTER TABLE metrics_views
             ADD CONSTRAINT fk_133318c712c1842a
                FOREIGN KEY (user_card_id)
                    REFERENCES user_cards (id)
                    ON DELETE CASCADE
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );

        $this->addSql(
            'ALTER TABLE metrics_views
             ADD CONSTRAINT fk_133318c7ccfa12b8
                FOREIGN KEY (profile_id)
                    REFERENCES profiles (id)
                    ON DELETE CASCADE
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
                );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE metrics_views');
    }
}
