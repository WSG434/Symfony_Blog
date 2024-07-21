<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240721093457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tags_to_blog RENAME INDEX fk_147ab9dbad26311 TO IDX_147AB9DBAD26311');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tags_to_blog RENAME INDEX idx_147ab9dbad26311 TO FK_147AB9DBAD26311');
        $this->addSql('ALTER TABLE blog DROP status');
    }
}
