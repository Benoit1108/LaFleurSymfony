<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127085244 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fleur (id INT AUTO_INCREMENT NOT NULL, une_categorie_id INT NOT NULL, designation VARCHAR(100) NOT NULL, prix DOUBLE PRECISION NOT NULL, photo VARCHAR(100) NOT NULL, INDEX IDX_3FFA92376D5A8E (une_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fleur ADD CONSTRAINT FK_3FFA92376D5A8E FOREIGN KEY (une_categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fleur');
    }
}
