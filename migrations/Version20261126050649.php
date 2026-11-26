<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261126050649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the initial discussion table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, discussion_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE discussion');
        $this->addSql('ALTER TABLE message ENGINE = MyISAM');
        $this->addSql('ALTER TABLE `user` ENGINE = MyISAM');
    }
}
