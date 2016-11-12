<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161105161744 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, thumbnail INT DEFAULT NULL, isVegan TINYINT(1) NOT NULL, name VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_DA88B1375E237E06 (name), UNIQUE INDEX UNIQ_DA88B137C35726E6 (thumbnail), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, recipe INT NOT NULL, filename VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, UNIQUE INDEX UNIQ_14B784183C0BE965 (filename), INDEX IDX_14B78418DA88B137 (recipe), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, manufacturer VARCHAR(40), vegan TINYINT(1) NOT NULL, gr SMALLINT NOT NULL, kcal INT NOT NULL, protein NUMERIC(10, 1) NOT NULL, carbs NUMERIC(10, 1) NOT NULL, sugar NUMERIC(10, 1) NOT NULL, fat NUMERIC(10, 1) NOT NULL, gfat NUMERIC(10, 1) NOT NULL, name VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_D34A04AD5E237E06 (name), INDEX IDX_D34A04AD3D0AE6DC (manufacturer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, recipe INT NOT NULL, product INT DEFAULT NULL, measurement INT DEFAULT NULL, amount SMALLINT DEFAULT NULL, position SMALLINT NOT NULL, INDEX IDX_6BAF7870DA88B137 (recipe), INDEX IDX_6BAF7870D34A04AD (product), INDEX IDX_6BAF78702CE0D811 (measurement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appUser (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4EB8D34A92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_4EB8D34AA0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cooking (id INT AUTO_INCREMENT NOT NULL, recipe INT NOT NULL, description VARCHAR(120) NOT NULL, position SMALLINT NOT NULL, INDEX IDX_467BE66ADA88B137 (recipe), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE measurement (id INT AUTO_INCREMENT NOT NULL, gr SMALLINT NOT NULL, name VARCHAR(40) NOT NULL, UNIQUE INDEX UNIQ_2CE0D8115E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137C35726E6 FOREIGN KEY (thumbnail) REFERENCES photo (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418DA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870DA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870D34A04AD FOREIGN KEY (product) REFERENCES product (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF78702CE0D811 FOREIGN KEY (measurement) REFERENCES measurement (id)');
        $this->addSql('ALTER TABLE cooking ADD CONSTRAINT FK_467BE66ADA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418DA88B137');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870DA88B137');
        $this->addSql('ALTER TABLE cooking DROP FOREIGN KEY FK_467BE66ADA88B137');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3D0AE6DC');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137C35726E6');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870D34A04AD');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF78702CE0D811');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE appUser');
        $this->addSql('DROP TABLE cooking');
        $this->addSql('DROP TABLE measurement');
    }
}
