<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240831192715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts ADD users_id INT NOT NULL');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_3340157367B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_3340157367B3B43D ON contacts (users_id)');
        $this->addSql('ALTER TABLE messages ADD users_id INT NOT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9667B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_DB021E9667B3B43D ON messages (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_3340157367B3B43D');
        $this->addSql('DROP INDEX IDX_3340157367B3B43D ON contacts');
        $this->addSql('ALTER TABLE contacts DROP users_id');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9667B3B43D');
        $this->addSql('DROP INDEX IDX_DB021E9667B3B43D ON messages');
        $this->addSql('ALTER TABLE messages DROP users_id');
    }
}
