<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210713074918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE studio DROP FOREIGN KEY FK_4A2B07B63C105691');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP INDEX IDX_4A2B07B63C105691 ON studio');
        $this->addSql('ALTER TABLE studio DROP coach_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coach (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, video_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, firstname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3F596DCC29C1004E (video_id), UNIQUE INDEX UNIQ_3F596DCCEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCC29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCCEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE studio ADD coach_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE studio ADD CONSTRAINT FK_4A2B07B63C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
        $this->addSql('CREATE INDEX IDX_4A2B07B63C105691 ON studio (coach_id)');
    }
}
