<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624150157 extends AbstractMigration
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
        $this->addSql('ALTER TABLE status DROP realtion, CHANGE video_id video_studio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C861055CA FOREIGN KEY (video_studio_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_7B00651C861055CA ON status (video_studio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C861055CA');
        $this->addSql('DROP INDEX IDX_7B00651C861055CA ON status');
        $this->addSql('ALTER TABLE status ADD realtion VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE video_studio_id video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_7B00651C29C1004E ON status (video_id)');
    }
}
