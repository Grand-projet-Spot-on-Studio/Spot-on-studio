<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708115758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C446F285F');
        $this->addSql('DROP INDEX IDX_7B00651C446F285F ON status');
        $this->addSql('ALTER TABLE status DROP studio_id');
        $this->addSql('ALTER TABLE studio ADD statuseses_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE studio ADD CONSTRAINT FK_4A2B07B63C7567F0 FOREIGN KEY (statuseses_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_4A2B07B63C7567F0 ON studio (statuseses_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status ADD studio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C446F285F FOREIGN KEY (studio_id) REFERENCES studio (id)');
        $this->addSql('CREATE INDEX IDX_7B00651C446F285F ON status (studio_id)');
        $this->addSql('ALTER TABLE studio DROP FOREIGN KEY FK_4A2B07B63C7567F0');
        $this->addSql('DROP INDEX IDX_4A2B07B63C7567F0 ON studio');
        $this->addSql('ALTER TABLE studio DROP statuseses_id');
    }
}
