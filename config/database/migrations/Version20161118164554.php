<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161118164554 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'CREATE TABLE orders (
            id INT AUTO_INCREMENT NOT NULL, 
            cook_id INT DEFAULT NULL, 
            waiter_id INT DEFAULT NULL, 
            name VARCHAR(255) NOT NULL, 
            dish VARCHAR(255) NOT NULL, 
            status VARCHAR(255) NOT NULL, 
            created DATETIME NOT NULL, 
            minutes INT DEFAULT NULL, 
            INDEX IDX_E52FFDEEB0D5B835 (cook_id), 
            INDEX IDX_E52FFDEEE9F3D07E (waiter_id), 
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEB0D5B835 FOREIGN KEY (cook_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEE9F3D07E FOREIGN KEY (waiter_id) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE orders');
    }
}
