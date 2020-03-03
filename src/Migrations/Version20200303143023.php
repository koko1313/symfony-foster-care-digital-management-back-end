<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303143023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE child (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, family_id_id BIGINT UNSIGNED DEFAULT NULL, region_id INT DEFAULT NULL, sub_region_id INT DEFAULT NULL, city_id INT DEFAULT NULL, egn VARCHAR(10) DEFAULT NULL, first_name VARCHAR(50) NOT NULL, second_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone VARCHAR(20) DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, birth_date DATE DEFAULT NULL, address LONGTEXT DEFAULT NULL, education VARCHAR(255) DEFAULT NULL, work VARCHAR(255) DEFAULT NULL, employment_type VARCHAR(255) DEFAULT NULL, citizenship VARCHAR(255) DEFAULT NULL, INDEX IDX_22B3542943330D24 (family_id_id), INDEX IDX_22B3542998260155 (region_id), INDEX IDX_22B354298A2B47EB (sub_region_id), INDEX IDX_22B354298BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B3542943330D24 FOREIGN KEY (family_id_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B3542998260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B354298A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B354298BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE child');
    }
}
