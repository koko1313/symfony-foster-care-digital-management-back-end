<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209213124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE family ADD region_id INT DEFAULT NULL, ADD sub_region_id INT DEFAULT NULL, ADD city_id INT DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B98260155 ON family (region_id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B8A2B47EB ON family (sub_region_id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B8BAC62AF ON family (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B98260155');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8A2B47EB');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8BAC62AF');
        $this->addSql('DROP INDEX IDX_A5E6215B98260155 ON family');
        $this->addSql('DROP INDEX IDX_A5E6215B8A2B47EB ON family');
        $this->addSql('DROP INDEX IDX_A5E6215B8BAC62AF ON family');
        $this->addSql('ALTER TABLE family DROP region_id, DROP sub_region_id, DROP city_id, DROP address');
    }
}
