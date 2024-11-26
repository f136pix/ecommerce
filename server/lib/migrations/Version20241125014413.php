<?php

declare(strict_types=1);

namespace App\Domain;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125014413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_items (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_items_product_attribute_values (order_item_id INT NOT NULL, product_attribute_value_id INT NOT NULL, INDEX IDX_F75F4E13E415FB15 (order_item_id), INDEX IDX_F75F4E139774A42E (product_attribute_value_id), PRIMARY KEY(order_item_id, product_attribute_value_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_items_product_attribute_values ADD CONSTRAINT FK_F75F4E13E415FB15 FOREIGN KEY (order_item_id) REFERENCES order_items (id)');
        $this->addSql('ALTER TABLE order_items_product_attribute_values ADD CONSTRAINT FK_F75F4E139774A42E FOREIGN KEY (product_attribute_value_id) REFERENCES product_attribute_values (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_items_product_attribute_values DROP FOREIGN KEY FK_F75F4E13E415FB15');
        $this->addSql('ALTER TABLE order_items_product_attribute_values DROP FOREIGN KEY FK_F75F4E139774A42E');
        $this->addSql('DROP TABLE order_items');
        $this->addSql('DROP TABLE order_items_product_attribute_values');
        $this->addSql('DROP TABLE orders');
    }
}
