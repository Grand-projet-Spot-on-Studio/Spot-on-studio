<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624123458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, studio_id INT DEFAULT NULL, video_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, realtion VARCHAR(255) NOT NULL, INDEX IDX_7B00651C446F285F (studio_id), INDEX IDX_7B00651C29C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studio_user (studio_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EC686DD1446F285F (studio_id), INDEX IDX_EC686DD1A76ED395 (user_id), PRIMARY KEY(studio_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C446F285F FOREIGN KEY (studio_id) REFERENCES studio (id)');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE studio_user ADD CONSTRAINT FK_EC686DD1446F285F FOREIGN KEY (studio_id) REFERENCES studio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studio_user ADD CONSTRAINT FK_EC686DD1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studio ADD user_employed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE studio ADD CONSTRAINT FK_4A2B07B69DA45FAC FOREIGN KEY (user_employed_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4A2B07B69DA45FAC ON studio (user_employed_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE studio_user');
        $this->addSql('ALTER TABLE studio DROP FOREIGN KEY FK_4A2B07B69DA45FAC');
        $this->addSql('DROP INDEX IDX_4A2B07B69DA45FAC ON studio');
        $this->addSql('ALTER TABLE studio DROP user_employed_id');
    }
}
