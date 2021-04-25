<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908144439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C9212EA736A');
        $this->addSql('DROP INDEX IDX_47CC8C9212EA736A ON action');
        $this->addSql('ALTER TABLE action CHANGE action_type_id_id action_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C921FEE0472 FOREIGN KEY (action_type_id) REFERENCES action_type (id)');
        $this->addSql('CREATE INDEX IDX_47CC8C921FEE0472 ON action (action_type_id)');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA729A6C08F');
        $this->addSql('DROP INDEX IDX_3BAE0AA729A6C08F ON event');
        $this->addSql('ALTER TABLE event CHANGE event_type_id_id event_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7401B253C FOREIGN KEY (event_type_id) REFERENCES event_type (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7401B253C ON event (event_type_id)');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDA3E5F2F7B');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDAD6328574');
        $this->addSql('DROP INDEX IDX_D979EFDAD6328574 ON scene');
        $this->addSql('DROP INDEX IDX_D979EFDA3E5F2F7B ON scene');
        $this->addSql('ALTER TABLE scene ADD place_id INT NOT NULL, ADD event_id INT NOT NULL, DROP place_id_id, DROP event_id_id');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDADA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDA71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_D979EFDADA6A219 ON scene (place_id)');
        $this->addSql('CREATE INDEX IDX_D979EFDA71F7E88B ON scene (event_id)');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB56043869CCBE9A');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB5604389777D11E');
        $this->addSql('DROP INDEX IDX_EB56043869CCBE9A ON story');
        $this->addSql('DROP INDEX IDX_EB5604389777D11E ON story');
        $this->addSql('ALTER TABLE story CHANGE author_id_id author_id INT NOT NULL, CHANGE category_id_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB560438F675F31B FOREIGN KEY (author_id) REFERENCES app_user (id)');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB56043812469DE2 FOREIGN KEY (category_id) REFERENCES story_category (id)');
        $this->addSql('CREATE INDEX IDX_EB560438F675F31B ON story (author_id)');
        $this->addSql('CREATE INDEX IDX_EB56043812469DE2 ON story (category_id)');
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A7AE0F8C4');
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A988A52EB');
        $this->addSql('DROP INDEX IDX_F715A75A7AE0F8C4 ON transition');
        $this->addSql('DROP INDEX IDX_F715A75A988A52EB ON transition');
        $this->addSql('ALTER TABLE transition CHANGE next_scene_id_id next_scene_id INT DEFAULT NULL, CHANGE action_id_id action_id INT NOT NULL');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A2E7A1F5A FOREIGN KEY (next_scene_id) REFERENCES scene (id)');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A9D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('CREATE INDEX IDX_F715A75A2E7A1F5A ON transition (next_scene_id)');
        $this->addSql('CREATE INDEX IDX_F715A75A9D32F035 ON transition (action_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C921FEE0472');
        $this->addSql('DROP INDEX IDX_47CC8C921FEE0472 ON action');
        $this->addSql('ALTER TABLE action CHANGE action_type_id action_type_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C9212EA736A FOREIGN KEY (action_type_id_id) REFERENCES action_type (id)');
        $this->addSql('CREATE INDEX IDX_47CC8C9212EA736A ON action (action_type_id_id)');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7401B253C');
        $this->addSql('DROP INDEX IDX_3BAE0AA7401B253C ON event');
        $this->addSql('ALTER TABLE event CHANGE event_type_id event_type_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA729A6C08F FOREIGN KEY (event_type_id_id) REFERENCES event_type (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA729A6C08F ON event (event_type_id_id)');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDADA6A219');
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDA71F7E88B');
        $this->addSql('DROP INDEX IDX_D979EFDADA6A219 ON scene');
        $this->addSql('DROP INDEX IDX_D979EFDA71F7E88B ON scene');
        $this->addSql('ALTER TABLE scene ADD place_id_id INT NOT NULL, ADD event_id_id INT NOT NULL, DROP place_id, DROP event_id');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDA3E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDAD6328574 FOREIGN KEY (place_id_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_D979EFDAD6328574 ON scene (place_id_id)');
        $this->addSql('CREATE INDEX IDX_D979EFDA3E5F2F7B ON scene (event_id_id)');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB560438F675F31B');
        $this->addSql('ALTER TABLE story DROP FOREIGN KEY FK_EB56043812469DE2');
        $this->addSql('DROP INDEX IDX_EB560438F675F31B ON story');
        $this->addSql('DROP INDEX IDX_EB56043812469DE2 ON story');
        $this->addSql('ALTER TABLE story CHANGE author_id author_id_id INT NOT NULL, CHANGE category_id category_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB56043869CCBE9A FOREIGN KEY (author_id_id) REFERENCES app_user (id)');
        $this->addSql('ALTER TABLE story ADD CONSTRAINT FK_EB5604389777D11E FOREIGN KEY (category_id_id) REFERENCES story_category (id)');
        $this->addSql('CREATE INDEX IDX_EB56043869CCBE9A ON story (author_id_id)');
        $this->addSql('CREATE INDEX IDX_EB5604389777D11E ON story (category_id_id)');
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A2E7A1F5A');
        $this->addSql('ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A9D32F035');
        $this->addSql('DROP INDEX IDX_F715A75A2E7A1F5A ON transition');
        $this->addSql('DROP INDEX IDX_F715A75A9D32F035 ON transition');
        $this->addSql('ALTER TABLE transition CHANGE next_scene_id next_scene_id_id INT DEFAULT NULL, CHANGE action_id action_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A7AE0F8C4 FOREIGN KEY (next_scene_id_id) REFERENCES scene (id)');
        $this->addSql('ALTER TABLE transition ADD CONSTRAINT FK_F715A75A988A52EB FOREIGN KEY (action_id_id) REFERENCES action (id)');
        $this->addSql('CREATE INDEX IDX_F715A75A7AE0F8C4 ON transition (next_scene_id_id)');
        $this->addSql('CREATE INDEX IDX_F715A75A988A52EB ON transition (action_id_id)');
    }
}
