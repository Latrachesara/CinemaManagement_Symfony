<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215223353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, titre VARCHAR(255) NOT NULL, annee INT NOT NULL, duree DOUBLE PRECISION NOT NULL, couverture VARCHAR(255) NOT NULL, INDEX IDX_8244BE22BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film_realisateur (film_id INT NOT NULL, realisateur_id INT NOT NULL, INDEX IDX_3F2B13F1567F5183 (film_id), INDEX IDX_3F2B13F1F1D8422E (realisateur_id), PRIMARY KEY(film_id, realisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle_film (salle_id INT NOT NULL, film_id INT NOT NULL, INDEX IDX_3FC4F7A2DC304035 (salle_id), INDEX IDX_3FC4F7A2567F5183 (film_id), PRIMARY KEY(salle_id, film_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE film_realisateur ADD CONSTRAINT FK_3F2B13F1567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_realisateur ADD CONSTRAINT FK_3F2B13F1F1D8422E FOREIGN KEY (realisateur_id) REFERENCES realisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_film ADD CONSTRAINT FK_3FC4F7A2DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_film ADD CONSTRAINT FK_3FC4F7A2567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22BCF5E72D');
        $this->addSql('ALTER TABLE film_realisateur DROP FOREIGN KEY FK_3F2B13F1567F5183');
        $this->addSql('ALTER TABLE salle_film DROP FOREIGN KEY FK_3FC4F7A2567F5183');
        $this->addSql('ALTER TABLE film_realisateur DROP FOREIGN KEY FK_3F2B13F1F1D8422E');
        $this->addSql('ALTER TABLE salle_film DROP FOREIGN KEY FK_3FC4F7A2DC304035');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE film_realisateur');
        $this->addSql('DROP TABLE realisateur');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE salle_film');
    }
}
