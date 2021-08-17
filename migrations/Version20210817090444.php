<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210817090444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coach_studio (coach_id INT NOT NULL, studio_id INT NOT NULL, INDEX IDX_91844C033C105691 (coach_id), INDEX IDX_91844C03446F285F (studio_id), PRIMARY KEY(coach_id, studio_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coach_studio ADD CONSTRAINT FK_91844C033C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coach_studio ADD CONSTRAINT FK_91844C03446F285F FOREIGN KEY (studio_id) REFERENCES studio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCC446F285F');
        $this->addSql('DROP INDEX IDX_3F596DCC446F285F ON coach');
        $this->addSql('ALTER TABLE coach DROP studio_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE coach_studio');
        $this->addSql('ALTER TABLE coach ADD studio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCC446F285F FOREIGN KEY (studio_id) REFERENCES studio (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_3F596DCC446F285F ON coach (studio_id)');
    }
}
