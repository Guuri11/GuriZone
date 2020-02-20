<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200220124821 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Usuario CHANGE rol rol INT DEFAULT NULL');
        $this->addSql('DROP INDEX tipo_rol ON Roles');
        $this->addSql('ALTER TABLE Producto ADD image_name VARCHAR(255) NOT NULL, ADD image_size INT NOT NULL, ADD updated_at DATETIME NOT NULL, CHANGE id_empleado id_empleado INT DEFAULT NULL, CHANGE categoria_prod categoria_prod INT DEFAULT NULL, CHANGE subcategoria_prod subcategoria_prod INT DEFAULT NULL');
        $this->addSql('DROP INDEX num_ref ON Pedido');
        $this->addSql('ALTER TABLE Pedido DROP num_ref, DROP cantidad, DROP descuento, DROP precio, DROP talla, DROP color, DROP fecha_pedido');
        $this->addSql('ALTER TABLE Pedido RENAME INDEX pedido_ibfk_2 TO IDX_C34013F8674163BB');
        $this->addSql('ALTER TABLE Subcategoria CHANGE cat_id cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Pedidos CHANGE cliente cliente INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Pedido ADD num_ref INT NOT NULL, ADD cantidad INT NOT NULL, ADD descuento DOUBLE PRECISION NOT NULL, ADD precio DOUBLE PRECISION NOT NULL, ADD talla VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, ADD color VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, ADD fecha_pedido DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX num_ref ON Pedido (num_ref)');
        $this->addSql('ALTER TABLE Pedido RENAME INDEX idx_c34013f8674163bb TO Pedido_ibfk_2');
        $this->addSql('ALTER TABLE Pedidos CHANGE cliente cliente INT NOT NULL');
        $this->addSql('ALTER TABLE Producto DROP image_name, DROP image_size, DROP updated_at, CHANGE categoria_prod categoria_prod INT NOT NULL, CHANGE subcategoria_prod subcategoria_prod INT NOT NULL, CHANGE id_empleado id_empleado INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX tipo_rol ON Roles (tipo_rol)');
        $this->addSql('ALTER TABLE Subcategoria CHANGE cat_id cat_id INT NOT NULL');
        $this->addSql('ALTER TABLE Usuario CHANGE rol rol INT NOT NULL');
    }
}
