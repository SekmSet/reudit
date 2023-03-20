<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320140615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD created DATE NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE categories ADD created DATE NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE comments ADD created DATE NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE label ADD created DATE NOT NULL, ADD updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users ADD created DATE NOT NULL, ADD updated DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP created, DROP updated');
        $this->addSql('ALTER TABLE categories DROP created, DROP updated');
        $this->addSql('ALTER TABLE comments DROP created, DROP updated');
        $this->addSql('ALTER TABLE label DROP created, DROP updated');
        $this->addSql('ALTER TABLE users DROP created, DROP updated');
    }
}
