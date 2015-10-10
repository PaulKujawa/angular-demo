<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151010205532 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Manufacturer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_253B3D245E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Reference (id INT AUTO_INCREMENT NOT NULL, agency INT NOT NULL, started DATE NOT NULL, finished DATE NOT NULL, url VARCHAR(50) NOT NULL, description VARCHAR(50) NOT NULL, filename VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, UNIQUE INDEX UNIQ_2C52CBB0F47645AE (url), INDEX IDX_2C52CBB070C0C6E6 (agency), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ReferenceTechnique (reference_id INT NOT NULL, technique_id INT NOT NULL, INDEX IDX_FE46BCCD1645DEA9 (reference_id), INDEX IDX_FE46BCCD1F8ACB26 (technique_id), PRIMARY KEY(reference_id, technique_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Agency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, url VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_776CC3D05E237E06 (name), UNIQUE INDEX UNIQ_776CC3D0F47645AE (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Photo (id INT AUTO_INCREMENT NOT NULL, recipe INT NOT NULL, name VARCHAR(40) NOT NULL, filename VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, UNIQUE INDEX UNIQ_D576AB1C5E237E06 (name), INDEX IDX_D576AB1CDA88B137 (recipe), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Measurement (id INT AUTO_INCREMENT NOT NULL, gr SMALLINT NOT NULL, name VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_AA7C57C65E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Product (id INT AUTO_INCREMENT NOT NULL, manufacturer INT NOT NULL, vegan TINYINT(1) NOT NULL, gr SMALLINT NOT NULL, kcal INT NOT NULL, protein NUMERIC(10, 1) NOT NULL, carbs NUMERIC(10, 1) NOT NULL, sugar NUMERIC(10, 1) NOT NULL, fat NUMERIC(10, 1) NOT NULL, gfat NUMERIC(10, 1) NOT NULL, name VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_1CF73D315E237E06 (name), INDEX IDX_1CF73D313D0AE6DC (manufacturer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Screenshot (id INT AUTO_INCREMENT NOT NULL, reference INT NOT NULL, name VARCHAR(40) NOT NULL, filename VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, UNIQUE INDEX UNIQ_17C41D915E237E06 (name), INDEX IDX_17C41D91AEA34913 (reference), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Recipe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_DD24B4015E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Technique (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, description VARCHAR(50) NOT NULL, url VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_55CA1AE25E237E06 (name), UNIQUE INDEX UNIQ_55CA1AE2F47645AE (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Ingredient (id INT NOT NULL, product INT DEFAULT NULL, measurement INT DEFAULT NULL, recipe INT NOT NULL, amount SMALLINT DEFAULT NULL, position SMALLINT NOT NULL, INDEX IDX_24F27BA0D34A04AD (product), INDEX IDX_24F27BA02CE0D811 (measurement), INDEX IDX_24F27BA0DA88B137 (recipe), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE AppUser (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8105EAD692FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8105EAD6A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Cooking (id INT NOT NULL, recipe INT NOT NULL, position SMALLINT NOT NULL, description VARCHAR(50) NOT NULL, INDEX IDX_89C6DFF6DA88B137 (recipe), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Reference ADD CONSTRAINT FK_2C52CBB070C0C6E6 FOREIGN KEY (agency) REFERENCES Agency (id)');
        $this->addSql('ALTER TABLE ReferenceTechnique ADD CONSTRAINT FK_FE46BCCD1645DEA9 FOREIGN KEY (reference_id) REFERENCES Reference (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ReferenceTechnique ADD CONSTRAINT FK_FE46BCCD1F8ACB26 FOREIGN KEY (technique_id) REFERENCES Technique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Photo ADD CONSTRAINT FK_D576AB1CDA88B137 FOREIGN KEY (recipe) REFERENCES Recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D313D0AE6DC FOREIGN KEY (manufacturer) REFERENCES Manufacturer (id)');
        $this->addSql('ALTER TABLE Screenshot ADD CONSTRAINT FK_17C41D91AEA34913 FOREIGN KEY (reference) REFERENCES Reference (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Ingredient ADD CONSTRAINT FK_24F27BA0D34A04AD FOREIGN KEY (product) REFERENCES Product (id)');
        $this->addSql('ALTER TABLE Ingredient ADD CONSTRAINT FK_24F27BA02CE0D811 FOREIGN KEY (measurement) REFERENCES Measurement (id)');
        $this->addSql('ALTER TABLE Ingredient ADD CONSTRAINT FK_24F27BA0DA88B137 FOREIGN KEY (recipe) REFERENCES Recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Cooking ADD CONSTRAINT FK_89C6DFF6DA88B137 FOREIGN KEY (recipe) REFERENCES Recipe (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D313D0AE6DC');
        $this->addSql('ALTER TABLE ReferenceTechnique DROP FOREIGN KEY FK_FE46BCCD1645DEA9');
        $this->addSql('ALTER TABLE Screenshot DROP FOREIGN KEY FK_17C41D91AEA34913');
        $this->addSql('ALTER TABLE Reference DROP FOREIGN KEY FK_2C52CBB070C0C6E6');
        $this->addSql('ALTER TABLE Ingredient DROP FOREIGN KEY FK_24F27BA02CE0D811');
        $this->addSql('ALTER TABLE Ingredient DROP FOREIGN KEY FK_24F27BA0D34A04AD');
        $this->addSql('ALTER TABLE Photo DROP FOREIGN KEY FK_D576AB1CDA88B137');
        $this->addSql('ALTER TABLE Ingredient DROP FOREIGN KEY FK_24F27BA0DA88B137');
        $this->addSql('ALTER TABLE Cooking DROP FOREIGN KEY FK_89C6DFF6DA88B137');
        $this->addSql('ALTER TABLE ReferenceTechnique DROP FOREIGN KEY FK_FE46BCCD1F8ACB26');
        $this->addSql('DROP TABLE Manufacturer');
        $this->addSql('DROP TABLE Reference');
        $this->addSql('DROP TABLE ReferenceTechnique');
        $this->addSql('DROP TABLE Agency');
        $this->addSql('DROP TABLE Photo');
        $this->addSql('DROP TABLE Measurement');
        $this->addSql('DROP TABLE Product');
        $this->addSql('DROP TABLE Screenshot');
        $this->addSql('DROP TABLE Recipe');
        $this->addSql('DROP TABLE Technique');
        $this->addSql('DROP TABLE Ingredient');
        $this->addSql('DROP TABLE AppUser');
        $this->addSql('DROP TABLE Cooking');
    }
}
