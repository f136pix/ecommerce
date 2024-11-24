<?php

declare(strict_types=1);

namespace App\Domain;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124043840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute_sets (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(52) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute_values (id INT AUTO_INCREMENT NOT NULL, displayValue VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, attributeSet_id INT DEFAULT NULL, INDEX IDX_184662BC7E570704 (attributeSet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brands (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_attribute_values (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, attributeSet_id INT DEFAULT NULL, attributeValue_id INT DEFAULT NULL, INDEX IDX_96CA06404584665A (product_id), INDEX IDX_96CA06407E570704 (attributeSet_id), INDEX IDX_96CA0640FF82614D (attributeValue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, category_id INT DEFAULT NULL, name VARCHAR(122) NOT NULL, description VARCHAR(255) NOT NULL, inStock TINYINT(1) NOT NULL, price NUMERIC(10, 2) NOT NULL, dtype VARCHAR(255) NOT NULL, INDEX IDX_B3BA5A5A44F5D008 (brand_id), INDEX IDX_B3BA5A5A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_images (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, position INT NOT NULL, dtype VARCHAR(255) NOT NULL, INDEX IDX_662C35404584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute_values ADD CONSTRAINT FK_184662BC7E570704 FOREIGN KEY (attributeSet_id) REFERENCES attribute_sets (id)');
        $this->addSql('ALTER TABLE product_attribute_values ADD CONSTRAINT FK_96CA06404584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE product_attribute_values ADD CONSTRAINT FK_96CA06407E570704 FOREIGN KEY (attributeSet_id) REFERENCES attribute_sets (id)');
        $this->addSql('ALTER TABLE product_attribute_values ADD CONSTRAINT FK_96CA0640FF82614D FOREIGN KEY (attributeValue_id) REFERENCES attribute_values (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE products_images ADD CONSTRAINT FK_662C35404584665A FOREIGN KEY (product_id) REFERENCES products (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute_values DROP FOREIGN KEY FK_184662BC7E570704');
        $this->addSql('ALTER TABLE product_attribute_values DROP FOREIGN KEY FK_96CA06404584665A');
        $this->addSql('ALTER TABLE product_attribute_values DROP FOREIGN KEY FK_96CA06407E570704');
        $this->addSql('ALTER TABLE product_attribute_values DROP FOREIGN KEY FK_96CA0640FF82614D');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A44F5D008');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE products_images DROP FOREIGN KEY FK_662C35404584665A');
        $this->addSql('DROP TABLE attribute_sets');
        $this->addSql('DROP TABLE attribute_values');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE product_attribute_values');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE products_images');
    }
}
