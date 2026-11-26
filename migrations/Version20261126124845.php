<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261126124845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Move the discussion relationship to each message and preserve existing links.';
    }

    public function preUp(Schema $schema): void
    {
        $duplicateLinks = (int) $this->connection->fetchOne(
            'SELECT COUNT(*) FROM (SELECT messages_id FROM discussion GROUP BY messages_id HAVING COUNT(*) > 1) AS duplicate_links'
        );

        if ($duplicateLinks > 0) {
            throw new \RuntimeException('A message is linked to multiple discussions; resolve these links before migrating.');
        }
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FA5905F5A');
        $this->addSql('DROP INDEX IDX_C0B9F90FA5905F5A ON discussion');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F93173582');
        $this->addSql('DROP INDEX IDX_B6BD307F93173582 ON message');
        $this->addSql('ALTER TABLE message ADD discussion_id INT DEFAULT NULL, CHANGE reciver_id receiver_id INT NOT NULL');
        $this->addSql('UPDATE message m INNER JOIN discussion d ON d.messages_id = m.id SET m.discussion_id = d.id');
        $this->addSql('ALTER TABLE discussion DROP messages_id');
    }

    public function down(Schema $schema): void
    {
        throw new \RuntimeException('This cardinality change cannot be reversed without risking message loss.');
    }
}
