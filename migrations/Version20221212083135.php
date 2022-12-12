<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212083135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, medecin_id INT NOT NULL, jour VARCHAR(255) NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, INDEX IDX_BBC83DB64F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, medecin_id INT DEFAULT NULL, type_consultation_id INT DEFAULT NULL, creneau DATETIME NOT NULL, INDEX IDX_10C31F86A76ED395 (user_id), INDEX IDX_10C31F864F31A84 (medecin_id), INDEX IDX_10C31F8695CBF8AB (type_consultation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_consultation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, duree INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_consultation_docteur (type_consultation_id INT NOT NULL, docteur_id INT NOT NULL, INDEX IDX_804B5F1195CBF8AB (type_consultation_id), INDEX IDX_804B5F11CF22540A (docteur_id), PRIMARY KEY(type_consultation_id, docteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE horaire ADD CONSTRAINT FK_BBC83DB64F31A84 FOREIGN KEY (medecin_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F864F31A84 FOREIGN KEY (medecin_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F8695CBF8AB FOREIGN KEY (type_consultation_id) REFERENCES type_consultation (id)');
        $this->addSql('ALTER TABLE type_consultation_docteur ADD CONSTRAINT FK_804B5F1195CBF8AB FOREIGN KEY (type_consultation_id) REFERENCES type_consultation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_consultation_docteur ADD CONSTRAINT FK_804B5F11CF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire DROP FOREIGN KEY FK_BBC83DB64F31A84');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86A76ED395');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F864F31A84');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F8695CBF8AB');
        $this->addSql('ALTER TABLE type_consultation_docteur DROP FOREIGN KEY FK_804B5F1195CBF8AB');
        $this->addSql('ALTER TABLE type_consultation_docteur DROP FOREIGN KEY FK_804B5F11CF22540A');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE type_consultation');
        $this->addSql('DROP TABLE type_consultation_docteur');
    }
}
