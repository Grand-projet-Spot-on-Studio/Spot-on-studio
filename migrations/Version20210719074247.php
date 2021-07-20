<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210719074247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCC446F285F');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCC446F285F FOREIGN KEY (studio_id) REFERENCES studio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C446F285F');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C446F285F FOREIGN KEY (studio_id) REFERENCES studio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studio DROP FOREIGN KEY FK_4A2B07B66BF700BD');
        $this->addSql('ALTER TABLE studio DROP FOREIGN KEY FK_4A2B07B69DA45FAC');
        $this->addSql('ALTER TABLE studio ADD CONSTRAINT FK_4A2B07B66BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studio ADD CONSTRAINT FK_4A2B07B69DA45FAC FOREIGN KEY (user_employed_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C3C105691');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C6BF700BD');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CA76ED395');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C6BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCC446F285F');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCC446F285F FOREIGN KEY (studio_id) REFERENCES studio (id)');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C446F285F');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C446F285F FOREIGN KEY (studio_id) REFERENCES studio (id)');
        $this->addSql('ALTER TABLE studio DROP FOREIGN KEY FK_4A2B07B69DA45FAC');
        $this->addSql('ALTER TABLE studio DROP FOREIGN KEY FK_4A2B07B66BF700BD');
        $this->addSql('ALTER TABLE studio ADD CONSTRAINT FK_4A2B07B69DA45FAC FOREIGN KEY (user_employed_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE studio ADD CONSTRAINT FK_4A2B07B66BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C6BF700BD');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CA76ED395');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C3C105691');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
    }
}
