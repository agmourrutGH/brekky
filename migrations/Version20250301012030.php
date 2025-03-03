<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301012030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calificacion (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, galeria_id INT DEFAULT NULL, puntuacion INT NOT NULL, INDEX IDX_8A3AF218A76ED395 (user_id), INDEX IDX_8A3AF218D31019C (galeria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galeria (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, imagen VARCHAR(255) NOT NULL, descripcion LONGTEXT NOT NULL, fecha_publicacion DATETIME NOT NULL, INDEX IDX_9910D189A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, categoria_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, imagen VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD3397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recomendacion (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(50) NOT NULL, contenido LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tienda (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, latitud NUMERIC(10, 7) NOT NULL, longitud NUMERIC(10, 7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, profile_picture VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, latitud DOUBLE PRECISION DEFAULT NULL, longitud DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calificacion ADD CONSTRAINT FK_8A3AF218A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE calificacion ADD CONSTRAINT FK_8A3AF218D31019C FOREIGN KEY (galeria_id) REFERENCES galeria (id)');
        $this->addSql('ALTER TABLE galeria ADD CONSTRAINT FK_9910D189A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calificacion DROP FOREIGN KEY FK_8A3AF218A76ED395');
        $this->addSql('ALTER TABLE calificacion DROP FOREIGN KEY FK_8A3AF218D31019C');
        $this->addSql('ALTER TABLE galeria DROP FOREIGN KEY FK_9910D189A76ED395');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3397707A');
        $this->addSql('DROP TABLE calificacion');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE galeria');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE recomendacion');
        $this->addSql('DROP TABLE tienda');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
