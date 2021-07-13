<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712132859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE studio ADD coach_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE studio ADD CONSTRAINT FK_4A2B07B63C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
        $this->addSql('CREATE INDEX IDX_4A2B07B63C105691 ON studio (coach_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE studio DROP FOREIGN KEY FK_4A2B07B63C105691');
        $this->addSql('DROP INDEX IDX_4A2B07B63C105691 ON studio');
        $this->addSql('ALTER TABLE studio DROP coach_id');
    }
}
