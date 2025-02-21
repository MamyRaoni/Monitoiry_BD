<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250216182303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit_compte CHANGE date_mise_jour date_mise_jour DATE NOT NULL, CHANGE numero_compte numero_compte VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE compte CHANGE numero_compte numero_compte VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audit_compte CHANGE date_mise_jour date_mise_jour DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE numero_compte numero_compte INT NOT NULL');
        $this->addSql('ALTER TABLE compte CHANGE numero_compte numero_compte INT NOT NULL');
    }
}
