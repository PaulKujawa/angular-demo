<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151108122934 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Reference DROP FOREIGN KEY FK_2C52CBB070C0C6E6');
        $this->addSql('ALTER TABLE ReferenceTechnique DROP FOREIGN KEY FK_FE46BCCD1645DEA9');
        $this->addSql('ALTER TABLE Screenshot DROP FOREIGN KEY FK_17C41D91AEA34913');
        $this->addSql('ALTER TABLE ReferenceTechnique DROP FOREIGN KEY FK_FE46BCCD1F8ACB26');
        $this->addSql('DROP TABLE Agency');
        $this->addSql('DROP TABLE Reference');
        $this->addSql('DROP TABLE ReferenceTechnique');
        $this->addSql('DROP TABLE Screenshot');
        $this->addSql('DROP TABLE Technique');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Agency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL COLLATE utf8_unicode_ci, url VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_776CC3D05E237E06 (name), UNIQUE INDEX UNIQ_776CC3D0F47645AE (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Reference (id INT AUTO_INCREMENT NOT NULL, agency INT NOT NULL, started DATE NOT NULL, finished DATE NOT NULL, url VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, description VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, filename VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, size INT DEFAULT NULL, UNIQUE INDEX UNIQ_2C52CBB0F47645AE (url), UNIQUE INDEX UNIQ_2C52CBB03C0BE965 (filename), INDEX IDX_2C52CBB070C0C6E6 (agency), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ReferenceTechnique (reference_id INT NOT NULL, technique_id INT NOT NULL, INDEX IDX_FE46BCCD1645DEA9 (reference_id), INDEX IDX_FE46BCCD1F8ACB26 (technique_id), PRIMARY KEY(reference_id, technique_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Screenshot (id INT AUTO_INCREMENT NOT NULL, reference INT NOT NULL, name VARCHAR(40) NOT NULL COLLATE utf8_unicode_ci, filename VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, size INT DEFAULT NULL, UNIQUE INDEX UNIQ_17C41D915E237E06 (name), UNIQUE INDEX UNIQ_17C41D913C0BE965 (filename), INDEX IDX_17C41D91AEA34913 (reference), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Technique (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL COLLATE utf8_unicode_ci, description VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, url VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_55CA1AE25E237E06 (name), UNIQUE INDEX UNIQ_55CA1AE2F47645AE (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Reference ADD CONSTRAINT FK_2C52CBB070C0C6E6 FOREIGN KEY (agency) REFERENCES Agency (id)');
        $this->addSql('ALTER TABLE ReferenceTechnique ADD CONSTRAINT FK_FE46BCCD1645DEA9 FOREIGN KEY (reference_id) REFERENCES Reference (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ReferenceTechnique ADD CONSTRAINT FK_FE46BCCD1F8ACB26 FOREIGN KEY (technique_id) REFERENCES Technique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Screenshot ADD CONSTRAINT FK_17C41D91AEA34913 FOREIGN KEY (reference) REFERENCES Reference (id) ON DELETE CASCADE');
    }
}
