<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010133830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advertisement ADD contract VARCHAR(255) NOT NULL, ADD worhing_time VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE company DROP working_time');
        $this->addSql('ALTER TABLE user ADD company_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64938B53C32 FOREIGN KEY (company_id_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64938B53C32 ON user (company_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64938B53C32');
        $this->addSql('DROP INDEX IDX_8D93D64938B53C32 ON user');
        $this->addSql('ALTER TABLE user DROP company_id_id');
        $this->addSql('ALTER TABLE advertisement DROP contract, DROP worhing_time');
        $this->addSql('ALTER TABLE company ADD working_time VARCHAR(255) NOT NULL');
    }
}
