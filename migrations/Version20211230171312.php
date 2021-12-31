<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230171312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE persons DROP FOREIGN KEY FK_A25CC7D3FE812AD');
        $this->addSql('ALTER TABLE persons ADD CONSTRAINT FK_A25CC7D3FE812AD FOREIGN KEY (persons_id) REFERENCES persons (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE persons DROP FOREIGN KEY FK_A25CC7D3FE812AD');
        $this->addSql('ALTER TABLE persons ADD CONSTRAINT FK_A25CC7D3FE812AD FOREIGN KEY (persons_id) REFERENCES persons (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
