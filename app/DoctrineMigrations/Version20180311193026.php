<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180311193026 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_DA88B137C35726E6 ON recipe');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137C35726E6');
        $this->addSql('DROP TABLE photo');
        $this->addSql('ALTER TABLE ingredient CHANGE amount amount NUMERIC(10, 1) DEFAULT NULL, CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE measurement CHANGE name name VARCHAR(40) NOT NULL COLLATE utf8_bin');
        $this->addSql('ALTER TABLE recipe ADD photosAmount INT NOT NULL, DROP thumbnail');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, recipe INT NOT NULL, filename VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, size INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_14B784183C0BE965 (filename), INDEX IDX_14B78418DA88B137 (recipe), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_D576AB1CDA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient CHANGE amount amount DOUBLE PRECISION DEFAULT NULL, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated updated DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE measurement CHANGE name name VARCHAR(40) DEFAULT \'\' NOT NULL COLLATE utf8_bin');
        $this->addSql('ALTER TABLE recipe ADD thumbnail INT DEFAULT NULL, DROP photosAmount');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137C35726E6 FOREIGN KEY (thumbnail) REFERENCES photo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA88B137C35726E6 ON recipe (thumbnail)');
    }
}
