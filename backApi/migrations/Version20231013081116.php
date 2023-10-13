<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013081116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advertisement (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, id_user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, location VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, wages VARCHAR(255) NOT NULL, contract VARCHAR(255) NOT NULL, working_time VARCHAR(255) NOT NULL, qualifications VARCHAR(255) DEFAULT NULL, INDEX IDX_C95F6AEE979B1AD6 (company_id), INDEX IDX_C95F6AEE79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, revenues VARCHAR(255) DEFAULT NULL, nb_employees INT DEFAULT NULL, domain VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulate (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, advertisement_id INT DEFAULT NULL, email_sent LONGTEXT DEFAULT NULL, date DATE NOT NULL, user_email VARCHAR(255) DEFAULT NULL, user_tel VARCHAR(255) DEFAULT NULL, user_name VARCHAR(255) DEFAULT NULL, user_last_name VARCHAR(255) DEFAULT NULL, INDEX IDX_2D0E4F3B79F37AE5 (id_user_id), INDEX IDX_2D0E4F3BA1FBF71B (advertisement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birth DATE NOT NULL, gender INT NOT NULL, phone VARCHAR(13) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advertisement ADD CONSTRAINT FK_C95F6AEE979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE advertisement ADD CONSTRAINT FK_C95F6AEE79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE postulate ADD CONSTRAINT FK_2D0E4F3B79F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE postulate ADD CONSTRAINT FK_2D0E4F3BA1FBF71B FOREIGN KEY (advertisement_id) REFERENCES advertisement (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advertisement DROP FOREIGN KEY FK_C95F6AEE979B1AD6');
        $this->addSql('ALTER TABLE advertisement DROP FOREIGN KEY FK_C95F6AEE79F37AE5');
        $this->addSql('ALTER TABLE postulate DROP FOREIGN KEY FK_2D0E4F3B79F37AE5');
        $this->addSql('ALTER TABLE postulate DROP FOREIGN KEY FK_2D0E4F3BA1FBF71B');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('DROP TABLE advertisement');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE postulate');
        $this->addSql('DROP TABLE `user`');
    }
}
