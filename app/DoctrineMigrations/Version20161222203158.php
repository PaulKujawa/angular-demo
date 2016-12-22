<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161222203158 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recipe ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL, CHANGE isVegan isVegan TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE photo ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE ingredient ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE cooking ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE measurement ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cooking DROP created, DROP updated');
        $this->addSql('ALTER TABLE ingredient DROP created, DROP updated');
        $this->addSql('ALTER TABLE measurement DROP created, DROP updated');
        $this->addSql('ALTER TABLE photo DROP created, DROP updated');
        $this->addSql('ALTER TABLE product DROP created, DROP updated');
        $this->addSql('ALTER TABLE recipe DROP created, DROP updated, CHANGE isVegan isVegan INT NOT NULL');
    }
}
