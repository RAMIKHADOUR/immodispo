<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240831191644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE descriptions ADD install_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE descriptions ADD CONSTRAINT FK_C96EAEB61BE7EDD8 FOREIGN KEY (install_id_id) REFERENCES installations (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C96EAEB61BE7EDD8 ON descriptions (install_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE descriptions DROP FOREIGN KEY FK_C96EAEB61BE7EDD8');
        $this->addSql('DROP INDEX UNIQ_C96EAEB61BE7EDD8 ON descriptions');
        $this->addSql('ALTER TABLE descriptions DROP install_id_id');
    }
}
