<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200219170108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Pedidos CHANGE cliente cliente INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Usuario CHANGE rol rol INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Producto CHANGE id_empleado id_empleado INT DEFAULT NULL, CHANGE categoria_prod categoria_prod INT DEFAULT NULL, CHANGE subcategoria_prod subcategoria_prod INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Pedido RENAME INDEX pedido_ibfk_2 TO IDX_C34013F8674163BB');
        $this->addSql('ALTER TABLE Subcategoria CHANGE cat_id cat_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Pedido RENAME INDEX idx_c34013f8674163bb TO Pedido_ibfk_2');
        $this->addSql('ALTER TABLE Pedidos CHANGE cliente cliente INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Producto CHANGE categoria_prod categoria_prod INT DEFAULT NULL, CHANGE subcategoria_prod subcategoria_prod INT DEFAULT NULL, CHANGE id_empleado id_empleado INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Subcategoria CHANGE cat_id cat_id INT NOT NULL');
        $this->addSql('ALTER TABLE Usuario CHANGE rol rol INT DEFAULT NULL');
    }
}
