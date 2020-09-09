<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909073214 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE sound_file sound_file VARCHAR(255) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE action_type CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE app_user CHANGE role role SMALLINT DEFAULT 1 NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE stories_played stories_played INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE avatar CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE picture_file picture_file VARCHAR(255) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE event CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE picture_file picture_file VARCHAR(255) DEFAULT \'\' NOT NULL, CHANGE sound_file sound_file VARCHAR(255) DEFAULT \'\' NOT NULL, CHANGE is_end is_end TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE event_type ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE place CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE picture_file picture_file VARCHAR(255) DEFAULT \'\' NOT NULL, CHANGE sound_file sound_file VARCHAR(255) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE place_type ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP created_at, CHANGE picture_file picture_file VARCHAR(255) DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE scene ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE story ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP created_at, CHANGE status status SMALLINT DEFAULT 2 NOT NULL, CHANGE rating rating SMALLINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE story_category ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE transition ADD createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP created_at');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action CHANGE created_at created_at DATETIME NOT NULL, CHANGE sound_file sound_file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE action_type CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE app_user CHANGE role role SMALLINT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE stories_played stories_played INT NOT NULL');
        $this->addSql('ALTER TABLE avatar CHANGE created_at created_at DATETIME NOT NULL, CHANGE picture_file picture_file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE event CHANGE created_at created_at DATETIME NOT NULL, CHANGE picture_file picture_file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sound_file sound_file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE is_end is_end TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE event_type ADD created_at DATETIME NOT NULL, DROP createdAt');
        $this->addSql('ALTER TABLE place CHANGE created_at created_at DATETIME NOT NULL, CHANGE picture_file picture_file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sound_file sound_file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE place_type ADD created_at DATETIME NOT NULL, DROP createdAt, CHANGE picture_file picture_file VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE scene ADD created_at DATETIME NOT NULL, DROP createdAt');
        $this->addSql('ALTER TABLE story ADD created_at DATETIME NOT NULL, DROP createdAt, CHANGE status status SMALLINT NOT NULL, CHANGE rating rating SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE story_category ADD created_at DATETIME NOT NULL, DROP createdAt');
        $this->addSql('ALTER TABLE transition ADD created_at DATETIME NOT NULL, DROP createdAt');
    }
}
