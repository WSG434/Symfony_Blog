<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240728150121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tags_to_blog RENAME INDEX fk_147ab9dbad26311 TO IDX_147AB9DBAD26311');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tags_to_blog RENAME INDEX idx_147ab9dbad26311 TO FK_147AB9DBAD26311');
    }
}

