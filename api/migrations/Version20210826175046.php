<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210826175046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profiles ADD theme_id UUID');
        $this->addSql('COMMENT ON COLUMN profiles.theme_id IS \'(DC2Type:entity_id)\'');
        $this->addSql(
            'ALTER TABLE profiles
             ADD CONSTRAINT fk_8b30853059027487
                FOREIGN KEY (theme_id)
                    REFERENCES themes (id)
                    ON DELETE RESTRICT
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql('CREATE INDEX IDX_8B30853059027487 ON profiles (theme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profiles DROP CONSTRAINT FK_8B30853059027487');
        $this->addSql('DROP INDEX IDX_8B30853059027487');
        $this->addSql('ALTER TABLE profiles DROP theme_id');
    }
}
