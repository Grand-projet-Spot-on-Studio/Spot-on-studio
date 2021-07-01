<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629084546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C29C1004E');
        $this->addSql('DROP INDEX IDX_7B00651C29C1004E ON status');
        $this->addSql('ALTER TABLE status DROP video_id');
        $this->addSql('ALTER TABLE video ADD media_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CEA9FDD75 ON video (media_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C6BF700BD ON video (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status ADD video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_7B00651C29C1004E ON status (video_id)');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CEA9FDD75');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C6BF700BD');
        $this->addSql('DROP INDEX IDX_7CC7DA2CEA9FDD75 ON video');
        $this->addSql('DROP INDEX IDX_7CC7DA2C6BF700BD ON video');
        $this->addSql('ALTER TABLE video DROP media_id, DROP status_id');
    }
}
