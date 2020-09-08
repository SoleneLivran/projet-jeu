<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908143517 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transition_scene (transition_id INT NOT NULL, scene_id INT NOT NULL, INDEX IDX_EB1FA9A98BF1A064 (transition_id), INDEX IDX_EB1FA9A9166053B4 (scene_id), PRIMARY KEY(transition_id, scene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place_place_type (place_id INT NOT NULL, place_type_id INT NOT NULL, INDEX IDX_68ABB1CDDA6A219 (place_id), INDEX IDX_68ABB1CDF1809B68 (place_type_id), PRIMARY KEY(place_id, place_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transition_scene ADD CONSTRAINT FK_EB1FA9A98BF1A064 FOREIGN KEY (transition_id) REFERENCES transition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transition_scene ADD CONSTRAINT FK_EB1FA9A9166053B4 FOREIGN KEY (scene_id) REFERENCES scene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE place_place_type ADD CONSTRAINT FK_68ABB1CDDA6A219 FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE place_place_type ADD CONSTRAINT FK_68ABB1CDF1809B68 FOREIGN KEY (place_type_id) REFERENCES place_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action ADD action_type_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C9212EA736A FOREIGN KEY (action_type_id_id) REFERENCES action_type (id)');
        $this->addSql('CREATE INDEX IDX_47CC8C9212EA736A ON action (action_type_id_id)');
        $this->addSql('ALTER TABLE app_user ADD avatar_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E96ED73160 FOREIGN KEY (avatar_id_id) REFERENCES avatar (id)');
        $this->addSql('CREATE INDEX IDX_88BDF3E96ED73160 ON app_user (avatar_id_id)');
        $this->addSql('ALTER TABLE event ADD event_type_id_id INT DEFAULT NULL, ADD is_end TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA729A6C08F FOREIGN KEY (event_type_id_id) REFERENCES event_type (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA729A6C08F ON event (event_type_id_id)');
        $this->addSql('ALTER TABLE scene ADD place_id_id INT NOT NULL, ADD event_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDAD6328574 FOREIGN KEY (place_id_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDA3E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_D979EFDAD6328574 ON scene (place_id_id)');
        $this->addSql('CREATE INDEX IDX_D979EFDA3E5F2F7B ON scene (event_id_id)');
        $this->addSql('ALTER TABLE story ADD author_id_id INT NOT NULL, ADD category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB56043869CCBE9A FOREIGN KEY (author_id_id) REFERENCES app_user (id)');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB5604389777D11E FOREIGN KEY (category_id_id) REFERENCES story_category (id)');
        $this->addSql('CREATE INDEX IDX_EB56043869CCBE9A ON story (author_id_id)');
        $this->addSql('CREATE INDEX IDX_EB5604389777D11E ON story (category_id_id)');
        $this->addSql('ALTER TABLE transition ADD next_scene_id_id INT DEFAULT NULL, ADD action_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A7AE0F8C4 FOREIGN KEY (next_scene_id_id) REFERENCES scene (id)');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A988A52EB FOREIGN KEY (action_id_id) REFERENCES action (id)');
        $this->addSql('CREATE INDEX IDX_F715A75A7AE0F8C4 ON transition (next_scene_id_id)');
        $this->addSql('CREATE INDEX IDX_F715A75A988A52EB ON transition (action_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE place_place_type');
        $this->addSql('DROP TABLE transition_scene');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C9212EA736A');
        $this->addSql('DROP INDEX IDX_47CC8C9212EA736A ON action');
        $this->addSql('ALTER TABLE action DROP action_type_id_id');
        $this->addSql('ALTER TABLE app_user DROP FOREIGN KEY FK_88BDF3E96ED73160');
        $this->addSql('DROP INDEX IDX_88BDF3E96ED73160 ON app_user');
        $this->addSql('ALTER TABLE app_user DROP avatar_id_id');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA729A6C08F');
        $this->addSql('DROP INDEX IDX_3BAE0AA729A6C08F ON event');
        $this->addSql('ALTER TABLE event DROP event_type_id_id, DROP is_end');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDAD6328574');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDA3E5F2F7B');
        $this->addSql('DROP INDEX IDX_D979EFDAD6328574 ON scene');
        $this->addSql('DROP INDEX IDX_D979EFDA3E5F2F7B ON scene');
        $this->addSql('ALTER TABLE scene DROP place_id_id, DROP event_id_id');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB56043869CCBE9A');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB5604389777D11E');
        $this->addSql('DROP INDEX IDX_EB56043869CCBE9A ON story');
        $this->addSql('DROP INDEX IDX_EB5604389777D11E ON story');
        $this->addSql('ALTER TABLE story DROP author_id_id, DROP category_id_id');
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A7AE0F8C4');
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A988A52EB');
        $this->addSql('DROP INDEX IDX_F715A75A7AE0F8C4 ON transition');
        $this->addSql('DROP INDEX IDX_F715A75A988A52EB ON transition');
        $this->addSql('ALTER TABLE transition DROP next_scene_id_id, DROP action_id_id');
    }
}
