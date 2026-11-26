<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261126135413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ensure the discussion and message foreign keys exist.';
    }

    public function up(Schema $schema): void
    {
        foreach ($this->foreignKeys() as [$table, $name, $sql]) {
            if (!$this->foreignKeyExists($table, $name)) {
                $this->addSql($sql);
            }
        }
    }

    public function down(Schema $schema): void
    {
        foreach ($this->foreignKeys() as [$table, $name]) {
            if ($this->foreignKeyExists($table, $name)) {
                $this->addSql(sprintf('ALTER TABLE %s DROP FOREIGN KEY %s', $table, $name));
            }
        }
    }

    private function foreignKeyExists(string $table, string $name): bool
    {
        return (int) $this->connection->fetchOne(
            'SELECT COUNT(*) FROM information_schema.KEY_COLUMN_USAGE
            WHERE CONSTRAINT_SCHEMA = DATABASE()
            AND TABLE_NAME = ?
            AND CONSTRAINT_NAME = ?
            AND REFERENCED_TABLE_NAME IS NOT NULL',
            [$table, $name]
        ) > 0;
    }

    private function foreignKeys(): array
    {
        return [
            ['discussion', 'FK_C0B9F90FF624B39D', 'ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)'],
            ['discussion', 'FK_C0B9F90FCD53EDB6', 'ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES `user` (id)'],
            ['message', 'FK_B6BD307FF624B39D', 'ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)'],
            ['message', 'FK_B6BD307FCD53EDB6', 'ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES `user` (id)'],
            ['message', 'FK_B6BD307F1ADED311', 'ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id)'],
        ];
    }
}
