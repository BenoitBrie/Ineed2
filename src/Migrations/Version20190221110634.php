<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190221110634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE annonce ADD categorie_id INT DEFAULT NULL, ADD membre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E56A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5BCF5E72D ON annonce (categorie_id)');
        $this->addSql('CREATE INDEX IDX_F65593E56A99F74A ON annonce (membre_id)');
        $this->addSql('ALTER TABLE membre CHANGE password password VARCHAR(64) NOT NULL, CHANGE date_inscription date_inscription DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BCF5E72D');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, username VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E56A99F74A');
        $this->addSql('DROP INDEX IDX_F65593E5BCF5E72D ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E56A99F74A ON annonce');
        $this->addSql('ALTER TABLE annonce DROP categorie_id, DROP membre_id');
        $this->addSql('ALTER TABLE membre CHANGE password password VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE date_inscription date_inscription DATETIME DEFAULT NULL');
    }
}
