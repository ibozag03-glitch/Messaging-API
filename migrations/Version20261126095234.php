<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261126095234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the original message relation to discussions.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion ADD messages_id INT NOT NULL');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FA5905F5A FOREIGN KEY (messages_id) REFERENCES message (id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90FA5905F5A ON discussion (messages_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FA5905F5A');
        $this->addSql('DROP INDEX IDX_C0B9F90FA5905F5A ON discussion');
        $this->addSql('ALTER TABLE discussion DROP messages_id');
    }
}
