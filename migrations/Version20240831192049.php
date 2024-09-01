<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240831192049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE types ADD price_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE types ADD CONSTRAINT FK_59308930548D9637 FOREIGN KEY (price_id_id) REFERENCES prices (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_59308930548D9637 ON types (price_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE types DROP FOREIGN KEY FK_59308930548D9637');
        $this->addSql('DROP INDEX UNIQ_59308930548D9637 ON types');
        $this->addSql('ALTER TABLE types DROP price_id_id');
    }
}
