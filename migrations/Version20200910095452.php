<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910095452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB560438A27861EF');
        $this->addSql('ALTER TABLE story CHANGE first_scene_id first_scene_id INT NOT NULL');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB560438A27861EF FOREIGN KEY (first_scene_id) REFERENCES scene (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB560438A27861EF');
        $this->addSql('ALTER TABLE story CHANGE first_scene_id first_scene_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB560438A27861EF FOREIGN KEY (first_scene_id) REFERENCES scene (id)');
    }
}
