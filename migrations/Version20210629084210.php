<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629084210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64929C1004E');
        $this->addSql('DROP INDEX IDX_8D93D64929C1004E ON user');
        $this->addSql('ALTER TABLE user DROP video_id');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C6BF700BD');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CA76ED395');
        $this->addSql('DROP INDEX IDX_7CC7DA2CA76ED395 ON video');
        $this->addSql('DROP INDEX IDX_7CC7DA2C6BF700BD ON video');
        $this->addSql('ALTER TABLE video DROP user_id, DROP status_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64929C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64929C1004E ON user (video_id)');
        $this->addSql('ALTER TABLE video ADD user_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CA76ED395 ON video (user_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C6BF700BD ON video (status_id)');
    }
}
