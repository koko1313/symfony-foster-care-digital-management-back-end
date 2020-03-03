<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303144222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B3542943330D24');
        $this->addSql('DROP INDEX IDX_22B3542943330D24 ON child');
        $this->addSql('ALTER TABLE child ADD warden_id BIGINT UNSIGNED DEFAULT NULL, CHANGE family_id_id family_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B35429C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B354299533F2F6 FOREIGN KEY (warden_id) REFERENCES employee_oepg (id)');
        $this->addSql('CREATE INDEX IDX_22B35429C35E566A ON child (family_id)');
        $this->addSql('CREATE INDEX IDX_22B354299533F2F6 ON child (warden_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B35429C35E566A');
        $this->addSql('ALTER TABLE child DROP FOREIGN KEY FK_22B354299533F2F6');
        $this->addSql('DROP INDEX IDX_22B35429C35E566A ON child');
        $this->addSql('DROP INDEX IDX_22B354299533F2F6 ON child');
        $this->addSql('ALTER TABLE child ADD family_id_id BIGINT UNSIGNED DEFAULT NULL, DROP family_id, DROP warden_id');
        $this->addSql('ALTER TABLE child ADD CONSTRAINT FK_22B3542943330D24 FOREIGN KEY (family_id_id) REFERENCES family (id)');
        $this->addSql('CREATE INDEX IDX_22B3542943330D24 ON child (family_id_id)');
    }
}
