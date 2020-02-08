<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200208214036 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE family ADD warden_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B9533F2F6 FOREIGN KEY (warden_id) REFERENCES employee_oepg (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B9533F2F6 ON family (warden_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B9533F2F6');
        $this->addSql('DROP INDEX IDX_A5E6215B9533F2F6 ON family');
        $this->addSql('ALTER TABLE family DROP warden_id');
    }
}
