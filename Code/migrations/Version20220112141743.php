<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112141743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, localisation_id INT NOT NULL, categorie_id INT NOT NULL, etat_id INT NOT NULL, statut_id INT NOT NULL, titre VARCHAR(128) NOT NULL, date_publication DATETIME NOT NULL, contenu LONGTEXT DEFAULT NULL, INDEX IDX_F65593E560BB6FE6 (auteur_id), INDEX IDX_F65593E5C68BE09C (localisation_id), INDEX IDX_F65593E5BCF5E72D (categorie_id), INDEX IDX_F65593E5D5E86FF (etat_id), INDEX IDX_F65593E5F6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, user_localisation_id INT NOT NULL, ville VARCHAR(50) NOT NULL, code_postal VARCHAR(5) NOT NULL, rue VARCHAR(255) NOT NULL, INDEX IDX_BFD3CE8FD4578C13 (user_localisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, expediteur_id INT NOT NULL, destinataire_id INT NOT NULL, date DATETIME NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_B6BD307F11D34840 (expediteur_id), INDEX IDX_B6BD307FA4F84F6E (destinataire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, path LONGTEXT NOT NULL, INDEX IDX_14B784188805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_echange (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(20) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, date_naissance DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_F7129A803AD8644E (user_source), INDEX IDX_F7129A80233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E560BB6FE6 FOREIGN KEY (auteur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5F6203804 FOREIGN KEY (statut_id) REFERENCES statut_echange (id)');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8FD4578C13 FOREIGN KEY (user_localisation_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F11D34840 FOREIGN KEY (expediteur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784188805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784188805AB2F');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BCF5E72D');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5D5E86FF');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C68BE09C');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5F6203804');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E560BB6FE6');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8FD4578C13');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F11D34840');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA4F84F6E');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80233D34C1');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE statut_echange');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_user');
    }
}
