<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320153541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF34668EA750E8 ON categories (label)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA750E8EA750E8 ON label (label)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_3AF34668EA750E8 ON categories');
        $this->addSql('DROP INDEX UNIQ_EA750E8EA750E8 ON label');
    }
}
