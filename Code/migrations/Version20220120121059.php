<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120121059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F974FC797');
        $this->addSql('DROP INDEX IDX_B6BD307F974FC797 ON message');
        $this->addSql('ALTER TABLE message CHANGE expéditeur_id expediteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F10335F61 FOREIGN KEY (expediteur_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F10335F61 ON message (expediteur_id)');
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F10335F61');
        $this->addSql('DROP INDEX IDX_B6BD307F10335F61 ON message');
        $this->addSql('ALTER TABLE message CHANGE expediteur_id expéditeur_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F974FC797 FOREIGN KEY (expéditeur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F974FC797 ON message (expéditeur_id)');
        $this->addSql('ALTER TABLE `user` DROP avatar');
    }
}
