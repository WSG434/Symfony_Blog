<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730164339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE blog_meta (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, author VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_372298A5DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_meta ADD CONSTRAINT FK_372298A5DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE blog_meta DROP FOREIGN KEY FK_372298A5DAE07E97');
        $this->addSql('DROP TABLE blog_meta');
    }
}
