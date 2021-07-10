<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707193455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE users
            (
                id uuid NOT NULL,
                email varchar(64) NOT NULL,
                password_hash varchar(255) DEFAULT NULL,
                status smallint NOT NULL,
                created_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                updated_at timestamp(0) WITHOUT TIME ZONE NOT NULL,
                last_auth_at timestamp(0) WITHOUT TIME ZONE DEFAULT NULL,
                confirm_token_value varchar(255) DEFAULT NULL,
                confirm_token_expires timestamp(0) WITHOUT TIME ZONE DEFAULT NULL,
                reset_token_value varchar(255) DEFAULT NULL,
                reset_token_expires timestamp(0) WITHOUT TIME ZONE DEFAULT NULL,
                PRIMARY KEY (id)
            )'
        );

        $this->addSql('CREATE UNIQUE INDEX users_email_uidx ON users (lower(email))');
        $this->addSql('CREATE UNIQUE INDEX users_confirm_token_value_uidx ON users (confirm_token_value)');
        $this->addSql('CREATE UNIQUE INDEX users_reset_token_value_uidx ON users (reset_token_value)');
        $this->addSql('CREATE INDEX users_status_idx ON users (status)');

        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:user_id)\'');
        $this->addSql('COMMENT ON COLUMN users.email IS \'(DC2Type:user_email)\'');
        $this->addSql('COMMENT ON COLUMN users.status IS \'(DC2Type:user_status)\'');
        $this->addSql('COMMENT ON COLUMN users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.last_auth_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.confirm_token_expires IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.reset_token_expires IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
    }
}
