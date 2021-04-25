<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909134140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, story_id INT NOT NULL, note SMALLINT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_D8892622AA5D4036 (story_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622AA5D4036 FOREIGN KEY (story_id) REFERENCES story (id)');
        $this->addSql('DROP TABLE transition_scene');
        $this->addSql('ALTER TABLE transition ADD current_scene_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A8B18299E FOREIGN KEY (current_scene_id) REFERENCES scene (id)');
        $this->addSql('CREATE INDEX IDX_F715A75A8B18299E ON transition (current_scene_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transition_scene (transition_id INT NOT NULL, scene_id INT NOT NULL, INDEX IDX_EB1FA9A98BF1A064 (transition_id), INDEX IDX_EB1FA9A9166053B4 (scene_id), PRIMARY KEY(transition_id, scene_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transition_scene ADD CONSTRAINT FK_EB1FA9A9166053B4 FOREIGN KEY (scene_id) REFERENCES scene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transition_scene ADD CONSTRAINT FK_EB1FA9A98BF1A064 FOREIGN KEY (transition_id) REFERENCES transition (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE rating');
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A8B18299E');
        $this->addSql('DROP INDEX IDX_F715A75A8B18299E ON transition');
        $this->addSql('ALTER TABLE transition DROP current_scene_id');
    }
}
