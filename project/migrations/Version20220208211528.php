<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208211528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, quote_id INT DEFAULT NULL, street VARCHAR(255) NOT NULL, postale VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_6FCA751619EB6921 (client_id), INDEX IDX_6FCA7516DB805178 (quote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billing (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, quote_id INT DEFAULT NULL, created_at DATE NOT NULL, status VARCHAR(255) NOT NULL, payement_method VARCHAR(255) NOT NULL, INDEX IDX_EC224CAA19EB6921 (client_id), UNIQUE INDEX UNIQ_EC224CAADB805178 (quote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, siret VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, language VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, creation_date DATE NOT NULL, discount INT DEFAULT NULL, deposit INT DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_6B71CBF419EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote_services (quote_id INT NOT NULL, services_id INT NOT NULL, INDEX IDX_990849F8DB805178 (quote_id), INDEX IDX_990849F8AEF5A6C1 (services_id), PRIMARY KEY(quote_id, services_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, time VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, velocity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA751619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA7516DB805178 FOREIGN KEY (quote_id) REFERENCES quote (id)');
        $this->addSql('ALTER TABLE billing ADD CONSTRAINT FK_EC224CAA19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE billing ADD CONSTRAINT FK_EC224CAADB805178 FOREIGN KEY (quote_id) REFERENCES quote (id)');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE quote_services ADD CONSTRAINT FK_990849F8DB805178 FOREIGN KEY (quote_id) REFERENCES quote (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quote_services ADD CONSTRAINT FK_990849F8AEF5A6C1 FOREIGN KEY (services_id) REFERENCES services (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA751619EB6921');
        $this->addSql('ALTER TABLE billing DROP FOREIGN KEY FK_EC224CAA19EB6921');
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF419EB6921');
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516DB805178');
        $this->addSql('ALTER TABLE billing DROP FOREIGN KEY FK_EC224CAADB805178');
        $this->addSql('ALTER TABLE quote_services DROP FOREIGN KEY FK_990849F8DB805178');
        $this->addSql('ALTER TABLE quote_services DROP FOREIGN KEY FK_990849F8AEF5A6C1');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE billing');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE quote_services');
        $this->addSql('DROP TABLE services');
    }
}
