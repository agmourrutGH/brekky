<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301020956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comentario (id INT AUTO_INCREMENT NOT NULL, galeria_id INT DEFAULT NULL, user_id INT DEFAULT NULL, contenido LONGTEXT NOT NULL, fecha_publicacion DATETIME NOT NULL, INDEX IDX_4B91E702D31019C (galeria_id), INDEX IDX_4B91E702A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E702D31019C FOREIGN KEY (galeria_id) REFERENCES galeria (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E702A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3397707A');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E702D31019C');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E702A76ED395');
        $this->addSql('DROP TABLE comentario');
    }
}
