<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227222022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calificacion (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, galeria_id INT DEFAULT NULL, puntuacion INT NOT NULL, INDEX IDX_8A3AF218A76ED395 (user_id), INDEX IDX_8A3AF218D31019C (galeria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galeria (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, imagen VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, fecha_publicacion DATETIME NOT NULL, INDEX IDX_9910D189A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calificacion ADD CONSTRAINT FK_8A3AF218A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE calificacion ADD CONSTRAINT FK_8A3AF218D31019C FOREIGN KEY (galeria_id) REFERENCES galeria (id)');
        $this->addSql('ALTER TABLE galeria ADD CONSTRAINT FK_9910D189A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3397707A');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calificacion DROP FOREIGN KEY FK_8A3AF218A76ED395');
        $this->addSql('ALTER TABLE calificacion DROP FOREIGN KEY FK_8A3AF218D31019C');
        $this->addSql('ALTER TABLE galeria DROP FOREIGN KEY FK_9910D189A76ED395');
        $this->addSql('DROP TABLE calificacion');
        $this->addSql('DROP TABLE galeria');
    }
}
