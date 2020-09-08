<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908144615 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_user DROP FOREIGN KEY FK_88BDF3E96ED73160');
        $this->addSql('DROP INDEX IDX_88BDF3E96ED73160 ON app_user');
        $this->addSql('ALTER TABLE app_user CHANGE avatar_id_id avatar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E986383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id)');
        $this->addSql('CREATE INDEX IDX_88BDF3E986383B10 ON app_user (avatar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_user DROP FOREIGN KEY FK_88BDF3E986383B10');
        $this->addSql('DROP INDEX IDX_88BDF3E986383B10 ON app_user');
        $this->addSql('ALTER TABLE app_user CHANGE avatar_id avatar_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E96ED73160 FOREIGN KEY (avatar_id_id) REFERENCES avatar (id)');
        $this->addSql('CREATE INDEX IDX_88BDF3E96ED73160 ON app_user (avatar_id_id)');
    }
}
