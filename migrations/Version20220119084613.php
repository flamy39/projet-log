<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220119084613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__log AS SELECT id, message, level, level_name, channel, created_at, context, extra FROM log');
        $this->addSql('DROP TABLE log');
        $this->addSql('CREATE TABLE log (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, message VARCHAR(255) NOT NULL COLLATE BINARY, level INTEGER NOT NULL, level_name VARCHAR(50) NOT NULL COLLATE BINARY, channel VARCHAR(60) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, context CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:array)
        , extra CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:array)
        , CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO log (id, message, level, level_name, channel, created_at, context, extra) SELECT id, message, level, level_name, channel, created_at, context, extra FROM __temp__log');
        $this->addSql('DROP TABLE __temp__log');
        $this->addSql('CREATE INDEX IDX_8F3F68C5A76ED395 ON log (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_8F3F68C5A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__log AS SELECT id, message, level, level_name, channel, created_at, context, extra FROM log');
        $this->addSql('DROP TABLE log');
        $this->addSql('CREATE TABLE log (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, message VARCHAR(255) NOT NULL, level INTEGER NOT NULL, level_name VARCHAR(50) NOT NULL, channel VARCHAR(60) NOT NULL, created_at DATETIME NOT NULL, context CLOB DEFAULT NULL --(DC2Type:array)
        , extra CLOB DEFAULT NULL --(DC2Type:array)
        )');
        $this->addSql('INSERT INTO log (id, message, level, level_name, channel, created_at, context, extra) SELECT id, message, level, level_name, channel, created_at, context, extra FROM __temp__log');
        $this->addSql('DROP TABLE __temp__log');
    }
}
