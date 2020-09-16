<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916121128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A2E7A1F5A');
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A8B18299E');
        $this->addSql('ALTER TABLE transition CHANGE current_scene_id current_scene_id INT NOT NULL');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A2E7A1F5A FOREIGN KEY (next_scene_id) REFERENCES scene (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A8B18299E FOREIGN KEY (current_scene_id) REFERENCES scene (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A8B18299E');
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A2E7A1F5A');
        $this->addSql('ALTER TABLE transition CHANGE current_scene_id current_scene_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A8B18299E FOREIGN KEY (current_scene_id) REFERENCES scene (id)');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A2E7A1F5A FOREIGN KEY (next_scene_id) REFERENCES scene (id)');
    }
}
