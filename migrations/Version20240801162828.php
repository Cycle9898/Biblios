<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801162828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ALTER created_by_id DROP DEFAULT');
        $this->addSql('ALTER TABLE "user" ADD last_connection_at DATE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN "user".last_connection_at IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book ALTER created_by_id SET DEFAULT 0');
        $this->addSql('ALTER TABLE "user" DROP last_connection_at');
    }
}
