<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201211092045 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, un_utilisateur_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_6EEAA67DB0141749 (un_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_commande_fleur (id INT AUTO_INCREMENT NOT NULL, une_commande_id INT NOT NULL, une_fleur_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_29442F11108EE1 (une_commande_id), INDEX IDX_29442F3414C6E8 (une_fleur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DB0141749 FOREIGN KEY (un_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE ligne_commande_fleur ADD CONSTRAINT FK_29442F11108EE1 FOREIGN KEY (une_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_commande_fleur ADD CONSTRAINT FK_29442F3414C6E8 FOREIGN KEY (une_fleur_id) REFERENCES fleur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_commande_fleur DROP FOREIGN KEY FK_29442F11108EE1');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE ligne_commande_fleur');
    }
}
