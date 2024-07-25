<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725084847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(15) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EB95123FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant_picture (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, filename VARCHAR(255) DEFAULT NULL, INDEX IDX_DC9013FCB1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, parent_id INT DEFAULT NULL, user_id INT NOT NULL, message LONGTEXT DEFAULT NULL, rating INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_794381C6B1E7706E (restaurant_id), INDEX IDX_794381C6727ACA70 (parent_id), INDEX IDX_794381C6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE restaurant_picture ADD CONSTRAINT FK_DC9013FCB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6727ACA70 FOREIGN KEY (parent_id) REFERENCES review (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FA76ED395');
        $this->addSql('ALTER TABLE restaurant_picture DROP FOREIGN KEY FK_DC9013FCB1E7706E');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6B1E7706E');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6727ACA70');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE restaurant_picture');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE user');
    }
}
