<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916120435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDAAA5D4036');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDAAA5D4036 FOREIGN KEY (story_id) REFERENCES story (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scene DROP FOREIGN KEY FK_D979EFDAAA5D4036');
        $this->addSql('ALTER TABLE scene ADD CONSTRAINT FK_D979EFDAAA5D4036 FOREIGN KEY (story_id) REFERENCES story (id)');
    }
}
