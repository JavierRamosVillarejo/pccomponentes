<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210125173733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrito (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carrito_articulo (carrito_id INT NOT NULL, articulo_id INT NOT NULL, INDEX IDX_AC926546DE2CF6E7 (carrito_id), INDEX IDX_AC9265462DBC2FC9 (articulo_id), PRIMARY KEY(carrito_id, articulo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carrito_articulo ADD CONSTRAINT FK_AC926546DE2CF6E7 FOREIGN KEY (carrito_id) REFERENCES carrito (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carrito_articulo ADD CONSTRAINT FK_AC9265462DBC2FC9 FOREIGN KEY (articulo_id) REFERENCES articulo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrito_articulo DROP FOREIGN KEY FK_AC926546DE2CF6E7');
        $this->addSql('DROP TABLE carrito');
        $this->addSql('DROP TABLE carrito_articulo');
    }
}
