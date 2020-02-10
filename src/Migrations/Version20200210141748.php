<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200210141748 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, sub_region_id INT NOT NULL, city_id INT NOT NULL, first_name VARCHAR(50) NOT NULL, second_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, address LONGTEXT DEFAULT NULL, dtype VARCHAR(255) NOT NULL, INDEX IDX_34DCD17698260155 (region_id), INDEX IDX_34DCD1768A2B47EB (sub_region_id), INDEX IDX_34DCD1768BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrator (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, sub_region_id INT NOT NULL, region_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B02348A2B47EB (sub_region_id), INDEX IDX_2D5B023498260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, position_id INT DEFAULT NULL, INDEX IDX_5D9F75A1DD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_oepg (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, warden_id INT DEFAULT NULL, region_id INT DEFAULT NULL, sub_region_id INT DEFAULT NULL, city_id INT DEFAULT NULL, titular VARCHAR(50) NOT NULL, woman_first_name VARCHAR(50) NOT NULL, woman_second_name VARCHAR(50) NOT NULL, woman_last_name VARCHAR(50) NOT NULL, man_first_name VARCHAR(50) NOT NULL, man_second_name VARCHAR(50) NOT NULL, man_last_name VARCHAR(50) NOT NULL, prefer_kid_gender VARCHAR(1) DEFAULT NULL, prefer_kid_min_age SMALLINT DEFAULT NULL, prefer_kid_max_age SMALLINT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, INDEX IDX_A5E6215B9533F2F6 (warden_id), INDEX IDX_A5E6215B98260155 (region_id), INDEX IDX_A5E6215B8A2B47EB (sub_region_id), INDEX IDX_A5E6215B8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_462CE4F5D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_region (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BD33BE3A98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17698260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1768A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1768BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651BF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02348A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee_oepg ADD CONSTRAINT FK_452DF6C8BF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B9533F2F6 FOREIGN KEY (warden_id) REFERENCES employee_oepg (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE sub_region ADD CONSTRAINT FK_BD33BE3A98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BF396750');
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651BF396750');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BF396750');
        $this->addSql('ALTER TABLE employee_oepg DROP FOREIGN KEY FK_452DF6C8BF396750');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD1768BAC62AF');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8BAC62AF');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B9533F2F6');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1DD842E46');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17698260155');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B023498260155');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B98260155');
        $this->addSql('ALTER TABLE sub_region DROP FOREIGN KEY FK_BD33BE3A98260155');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F5D60322AC');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD1768A2B47EB');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02348A2B47EB');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8A2B47EB');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_oepg');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE sub_region');
    }
}
