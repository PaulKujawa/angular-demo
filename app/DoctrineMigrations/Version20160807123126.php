<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160807123126 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX uniq_253b3d245e237e06 ON manufacturer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D0AE6DC5E237E06 ON manufacturer (name)');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_D576AB1CDA88B137');
        $this->addSql('DROP INDEX uniq_d576ab1c3c0be965 ON photo');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_14B784183C0BE965 ON photo (filename)');
        $this->addSql('DROP INDEX idx_d576ab1cda88b137 ON photo');
        $this->addSql('CREATE INDEX IDX_14B78418DA88B137 ON photo (recipe)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_D576AB1CDA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX uniq_aa7c57c65e237e06 ON measurement');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2CE0D8115E237E06 ON measurement (name)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_1CF73D313D0AE6DC');
        $this->addSql('DROP INDEX uniq_1cf73d315e237e06 ON product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD5E237E06 ON product (name)');
        $this->addSql('DROP INDEX idx_1cf73d313d0ae6dc ON product');
        $this->addSql('CREATE INDEX IDX_D34A04AD3D0AE6DC ON product (manufacturer)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_1CF73D313D0AE6DC FOREIGN KEY (manufacturer) REFERENCES manufacturer (id)');
        $this->addSql('ALTER TABLE recipe ADD thumbnail INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137C35726E6 FOREIGN KEY (thumbnail) REFERENCES photo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA88B137C35726E6 ON recipe (thumbnail)');
        $this->addSql('DROP INDEX uniq_dd24b4015e237e06 ON recipe');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA88B1375E237E06 ON recipe (name)');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_24F27BA02CE0D811');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_24F27BA0D34A04AD');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_24F27BA0DA88B137');
        $this->addSql('DROP INDEX idx_24f27ba0da88b137 ON ingredient');
        $this->addSql('CREATE INDEX IDX_6BAF7870DA88B137 ON ingredient (recipe)');
        $this->addSql('DROP INDEX idx_24f27ba0d34a04ad ON ingredient');
        $this->addSql('CREATE INDEX IDX_6BAF7870D34A04AD ON ingredient (product)');
        $this->addSql('DROP INDEX idx_24f27ba02ce0d811 ON ingredient');
        $this->addSql('CREATE INDEX IDX_6BAF78702CE0D811 ON ingredient (measurement)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_24F27BA02CE0D811 FOREIGN KEY (measurement) REFERENCES measurement (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_24F27BA0D34A04AD FOREIGN KEY (product) REFERENCES product (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_24F27BA0DA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX uniq_8105ead692fc23a8 ON appUser');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4EB8D34A92FC23A8 ON appUser (username_canonical)');
        $this->addSql('DROP INDEX uniq_8105ead6a0d96fbf ON appUser');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4EB8D34AA0D96FBF ON appUser (email_canonical)');
        $this->addSql('ALTER TABLE cooking DROP FOREIGN KEY FK_89C6DFF6DA88B137');
        $this->addSql('DROP INDEX idx_89c6dff6da88b137 ON cooking');
        $this->addSql('CREATE INDEX IDX_467BE66ADA88B137 ON cooking (recipe)');
        $this->addSql('ALTER TABLE cooking ADD CONSTRAINT FK_89C6DFF6DA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX uniq_4eb8d34a92fc23a8 ON appUser');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8105EAD692FC23A8 ON appUser (username_canonical)');
        $this->addSql('DROP INDEX uniq_4eb8d34aa0d96fbf ON appUser');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8105EAD6A0D96FBF ON appUser (email_canonical)');
        $this->addSql('ALTER TABLE cooking DROP FOREIGN KEY FK_467BE66ADA88B137');
        $this->addSql('DROP INDEX idx_467be66ada88b137 ON cooking');
        $this->addSql('CREATE INDEX IDX_89C6DFF6DA88B137 ON cooking (recipe)');
        $this->addSql('ALTER TABLE cooking ADD CONSTRAINT FK_467BE66ADA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870DA88B137');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870D34A04AD');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF78702CE0D811');
        $this->addSql('DROP INDEX idx_6baf7870da88b137 ON ingredient');
        $this->addSql('CREATE INDEX IDX_24F27BA0DA88B137 ON ingredient (recipe)');
        $this->addSql('DROP INDEX idx_6baf7870d34a04ad ON ingredient');
        $this->addSql('CREATE INDEX IDX_24F27BA0D34A04AD ON ingredient (product)');
        $this->addSql('DROP INDEX idx_6baf78702ce0d811 ON ingredient');
        $this->addSql('CREATE INDEX IDX_24F27BA02CE0D811 ON ingredient (measurement)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870DA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870D34A04AD FOREIGN KEY (product) REFERENCES product (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF78702CE0D811 FOREIGN KEY (measurement) REFERENCES measurement (id)');
        $this->addSql('DROP INDEX uniq_3d0ae6dc5e237e06 ON manufacturer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_253B3D245E237E06 ON manufacturer (name)');
        $this->addSql('DROP INDEX uniq_2ce0d8115e237e06 ON measurement');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA7C57C65E237E06 ON measurement (name)');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418DA88B137');
        $this->addSql('DROP INDEX uniq_14b784183c0be965 ON photo');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D576AB1C3C0BE965 ON photo (filename)');
        $this->addSql('DROP INDEX idx_14b78418da88b137 ON photo');
        $this->addSql('CREATE INDEX IDX_D576AB1CDA88B137 ON photo (recipe)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418DA88B137 FOREIGN KEY (recipe) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3D0AE6DC');
        $this->addSql('DROP INDEX uniq_d34a04ad5e237e06 ON product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CF73D315E237E06 ON product (name)');
        $this->addSql('DROP INDEX idx_d34a04ad3d0ae6dc ON product');
        $this->addSql('CREATE INDEX IDX_1CF73D313D0AE6DC ON product (manufacturer)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3D0AE6DC FOREIGN KEY (manufacturer) REFERENCES manufacturer (id)');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137C35726E6');
        $this->addSql('DROP INDEX UNIQ_DA88B137C35726E6 ON recipe');
        $this->addSql('ALTER TABLE recipe DROP thumbnail');
        $this->addSql('DROP INDEX uniq_da88b1375e237e06 ON recipe');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DD24B4015E237E06 ON recipe (name)');
    }
}
