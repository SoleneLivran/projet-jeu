<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200924134736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, send_by VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action CHANGE sound_file sound_file VARCHAR(255) DEFAULT \'default_action\' NOT NULL');
        $this->addSql('ALTER TABLE avatar CHANGE picture_file picture_file VARCHAR(255) DEFAULT \'default_avatar\' NOT NULL');
        $this->addSql('ALTER TABLE event CHANGE picture_file picture_file VARCHAR(255) DEFAULT \'default_event\' NOT NULL, CHANGE sound_file sound_file VARCHAR(255) DEFAULT \'default_event\' NOT NULL');
        $this->addSql('ALTER TABLE place CHANGE picture_file picture_file VARCHAR(255) DEFAULT \'default_place\' NOT NULL, CHANGE sound_file sound_file VARCHAR(255) DEFAULT \'default_place\' NOT NULL');
        $this->addSql('ALTER TABLE place_type CHANGE picture_file picture_file VARCHAR(255) DEFAULT \'default_place_type\' NOT NULL');
        $this->addSql('ALTER TABLE story CHANGE picture_file picture_file VARCHAR(255) DEFAULT \'default_story\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact');
        $this->addSql('ALTER TABLE action CHANGE sound_file sound_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE avatar CHANGE picture_file picture_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE event CHANGE picture_file picture_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sound_file sound_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE place CHANGE picture_file picture_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sound_file sound_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE place_type CHANGE picture_file picture_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE story CHANGE picture_file picture_file VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
