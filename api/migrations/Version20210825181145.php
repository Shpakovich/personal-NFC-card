<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825181145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE themes
            (
                id uuid NOT NULL,
                name varchar(100) NOT NULL,
                code varchar(15) NOT NULL,
                PRIMARY KEY (id)
            )'
        );
        $this->addSql('CREATE UNIQUE INDEX themes_code_uidx ON themes (code)');
        $this->addSql('COMMENT ON COLUMN themes.id IS \'(DC2Type:entity_id)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE themes');
    }
}
