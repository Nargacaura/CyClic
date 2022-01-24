<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112141818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F11D34840');
        $this->addSql('DROP INDEX IDX_B6BD307F11D34840 ON message');
        $this->addSql('ALTER TABLE message CHANGE expediteur_id expediteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F11D34840 FOREIGN KEY (expediteur_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F11D34840 ON message (expediteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F11D34840');
        $this->addSql('DROP INDEX IDX_B6BD307F11D34840 ON message');
        $this->addSql('ALTER TABLE message CHANGE expediteur_id expediteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F11D34840 FOREIGN KEY (expediteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F11D34840 ON message (expediteur_id)');
    }
}
