<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910094724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE story ADD first_scene_id INT DEFAULT NULL, ADD title VARCHAR(255) NOT NULL, ADD picture_file VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB560438A27861EF FOREIGN KEY (first_scene_id) REFERENCES scene (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB560438A27861EF ON story (first_scene_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB560438A27861EF');
        $this->addSql('DROP INDEX UNIQ_EB560438A27861EF ON story');
        $this->addSql('ALTER TABLE story DROP first_scene_id, DROP title, DROP picture_file');
    }
}
