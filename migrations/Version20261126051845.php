<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261126051845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adjust initial discussion columns and indexes.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP discussion_id, DROP created_at, DROP updated_at');
        $this->addSql('CREATE INDEX IDX_C0B9F90FF624B39D ON discussion (sender_id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90FCD53EDB6 ON discussion (receiver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_C0B9F90FF624B39D ON discussion');
        $this->addSql('DROP INDEX IDX_C0B9F90FCD53EDB6 ON discussion');
        $this->addSql('ALTER TABLE discussion ADD discussion_id INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
    }
}
