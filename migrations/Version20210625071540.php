<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625071540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C861055CA');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP INDEX IDX_7B00651C861055CA ON status');
        $this->addSql('ALTER TABLE status DROP video_studio_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, duration TIME DEFAULT NULL, number_view INT DEFAULT NULL, sampling TINYINT(1) DEFAULT NULL, time_sampling TIME DEFAULT NULL, difficulty INT DEFAULT NULL, programing_date INT DEFAULT NULL, average DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE status ADD video_studio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C861055CA FOREIGN KEY (video_studio_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_7B00651C861055CA ON status (video_studio_id)');
    }
}
