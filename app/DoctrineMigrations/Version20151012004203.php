<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151012004203 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_2C52CBB03C0BE965 ON Reference (filename)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D576AB1C3C0BE965 ON Photo (filename)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17C41D913C0BE965 ON Screenshot (filename)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_D576AB1C3C0BE965 ON Photo');
        $this->addSql('DROP INDEX UNIQ_2C52CBB03C0BE965 ON Reference');
        $this->addSql('DROP INDEX UNIQ_17C41D913C0BE965 ON Screenshot');
    }
}
