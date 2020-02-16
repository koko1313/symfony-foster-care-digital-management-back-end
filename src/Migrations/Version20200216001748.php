<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200216001748 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, sub_region_id INT DEFAULT NULL, city_id INT DEFAULT NULL, egn VARCHAR(10) DEFAULT NULL, first_name VARCHAR(50) NOT NULL, second_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone VARCHAR(20) DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, birth_date DATE DEFAULT NULL, address LONGTEXT DEFAULT NULL, education VARCHAR(255) DEFAULT NULL, work VARCHAR(255) DEFAULT NULL, employment_type VARCHAR(255) DEFAULT NULL, citizenship VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64998260155 (region_id), INDEX IDX_8D93D6498A2B47EB (sub_region_id), INDEX IDX_8D93D6498BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (user_id BIGINT UNSIGNED NOT NULL, role_id INT NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrator (id BIGINT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, sub_region_id INT NOT NULL, region_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B02348A2B47EB (sub_region_id), INDEX IDX_2D5B023498260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_oepg (id BIGINT UNSIGNED NOT NULL, position_id INT DEFAULT NULL, INDEX IDX_452DF6C8DD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, woman_id BIGINT UNSIGNED DEFAULT NULL, man_id BIGINT UNSIGNED DEFAULT NULL, warden_id BIGINT UNSIGNED DEFAULT NULL, region_id INT DEFAULT NULL, sub_region_id INT DEFAULT NULL, city_id INT DEFAULT NULL, titular VARCHAR(50) NOT NULL, prefer_kid_gender VARCHAR(20) DEFAULT NULL, prefer_kid_min_age SMALLINT DEFAULT NULL, prefer_kid_max_age SMALLINT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, language VARCHAR(255) DEFAULT NULL, level_of_bulgarian_language VARCHAR(255) DEFAULT NULL, religion VARCHAR(255) DEFAULT NULL, family_type VARCHAR(255) DEFAULT NULL, average_monthly_income_per_family_member DOUBLE PRECISION DEFAULT NULL, house_type VARCHAR(255) DEFAULT NULL, employment_type VARCHAR(255) DEFAULT NULL, another_income DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_A5E6215BEC88A587 (woman_id), UNIQUE INDEX UNIQ_A5E6215BE3037FC8 (man_id), INDEX IDX_A5E6215B9533F2F6 (warden_id), INDEX IDX_A5E6215B98260155 (region_id), INDEX IDX_A5E6215B8A2B47EB (sub_region_id), INDEX IDX_A5E6215B8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_member (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, sub_region_id INT DEFAULT NULL, city_id INT DEFAULT NULL, family_id BIGINT UNSIGNED NOT NULL, egn VARCHAR(10) DEFAULT NULL, first_name VARCHAR(50) NOT NULL, second_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone VARCHAR(20) DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, birth_date DATE DEFAULT NULL, address LONGTEXT DEFAULT NULL, education VARCHAR(255) DEFAULT NULL, work VARCHAR(255) DEFAULT NULL, employment_type VARCHAR(255) DEFAULT NULL, citizenship VARCHAR(255) DEFAULT NULL, relation VARCHAR(255) NOT NULL, note LONGTEXT NOT NULL, INDEX IDX_B9D4AD6D98260155 (region_id), INDEX IDX_B9D4AD6D8A2B47EB (sub_region_id), INDEX IDX_B9D4AD6D8BAC62AF (city_id), INDEX IDX_B9D4AD6DC35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE foster_parent (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, sub_region_id INT DEFAULT NULL, city_id INT DEFAULT NULL, egn VARCHAR(10) DEFAULT NULL, first_name VARCHAR(50) NOT NULL, second_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone VARCHAR(20) DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, birth_date DATE DEFAULT NULL, address LONGTEXT DEFAULT NULL, education VARCHAR(255) DEFAULT NULL, work VARCHAR(255) DEFAULT NULL, employment_type VARCHAR(255) DEFAULT NULL, citizenship VARCHAR(255) DEFAULT NULL, INDEX IDX_C296ABDC98260155 (region_id), INDEX IDX_C296ABDC8A2B47EB (sub_region_id), INDEX IDX_C296ABDC8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_462CE4F5D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_region (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BD33BE3A98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64998260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02348A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE employee_oepg ADD CONSTRAINT FK_452DF6C8DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE employee_oepg ADD CONSTRAINT FK_452DF6C8BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215BEC88A587 FOREIGN KEY (woman_id) REFERENCES foster_parent (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215BE3037FC8 FOREIGN KEY (man_id) REFERENCES foster_parent (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B9533F2F6 FOREIGN KEY (warden_id) REFERENCES employee_oepg (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE family_member ADD CONSTRAINT FK_B9D4AD6D98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE family_member ADD CONSTRAINT FK_B9D4AD6D8A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE family_member ADD CONSTRAINT FK_B9D4AD6D8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE family_member ADD CONSTRAINT FK_B9D4AD6DC35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE foster_parent ADD CONSTRAINT FK_C296ABDC98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE foster_parent ADD CONSTRAINT FK_C296ABDC8A2B47EB FOREIGN KEY (sub_region_id) REFERENCES sub_region (id)');
        $this->addSql('ALTER TABLE foster_parent ADD CONSTRAINT FK_C296ABDC8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE sub_region ADD CONSTRAINT FK_BD33BE3A98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651BF396750');
        $this->addSql('ALTER TABLE employee_oepg DROP FOREIGN KEY FK_452DF6C8BF396750');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498BAC62AF');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8BAC62AF');
        $this->addSql('ALTER TABLE family_member DROP FOREIGN KEY FK_B9D4AD6D8BAC62AF');
        $this->addSql('ALTER TABLE foster_parent DROP FOREIGN KEY FK_C296ABDC8BAC62AF');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B9533F2F6');
        $this->addSql('ALTER TABLE family_member DROP FOREIGN KEY FK_B9D4AD6DC35E566A');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215BEC88A587');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215BE3037FC8');
        $this->addSql('ALTER TABLE employee_oepg DROP FOREIGN KEY FK_452DF6C8DD842E46');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64998260155');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B023498260155');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B98260155');
        $this->addSql('ALTER TABLE family_member DROP FOREIGN KEY FK_B9D4AD6D98260155');
        $this->addSql('ALTER TABLE foster_parent DROP FOREIGN KEY FK_C296ABDC98260155');
        $this->addSql('ALTER TABLE sub_region DROP FOREIGN KEY FK_BD33BE3A98260155');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F5D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498A2B47EB');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02348A2B47EB');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B8A2B47EB');
        $this->addSql('ALTER TABLE family_member DROP FOREIGN KEY FK_B9D4AD6D8A2B47EB');
        $this->addSql('ALTER TABLE foster_parent DROP FOREIGN KEY FK_C296ABDC8A2B47EB');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE employee_oepg');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE family_member');
        $this->addSql('DROP TABLE foster_parent');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE sub_region');
    }
}
