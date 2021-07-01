<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701093210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media ADD video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C29C1004E ON media (video_id)');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CEA9FDD75');
        $this->addSql('DROP INDEX IDX_7CC7DA2CEA9FDD75 ON video');
        $this->addSql('ALTER TABLE video DROP media_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C29C1004E');
        $this->addSql('DROP INDEX IDX_6A2CA10C29C1004E ON media');
        $this->addSql('ALTER TABLE media DROP video_id');
        $this->addSql('ALTER TABLE video ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CEA9FDD75 ON video (media_id)');
    }
}
