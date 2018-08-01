<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180801225321 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand (id INT AUTO_INCREMENT NOT NULL, status TINYINT(1) NOT NULL, certificate VARCHAR(255) NOT NULL, nb_certificate INT NOT NULL, certificate_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, status TINYINT(1) NOT NULL, publishing_date DATETIME NOT NULL, modification_date DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\', lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, registration_date DATE NOT NULL, image VARCHAR(255) DEFAULT NULL, date_of_birth DATE DEFAULT NULL, gender TINYINT(1) DEFAULT NULL, token INT DEFAULT NULL, token_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE observation (id INT AUTO_INCREMENT NOT NULL, observation_date DATETIME NOT NULL, adding_date DATETIME NOT NULL, validation_date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bird (id INT AUTO_INCREMENT NOT NULL, reign VARCHAR(255) NOT NULL, phylum VARCHAR(255) NOT NULL, name_class VARCHAR(255) NOT NULL, name_order VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, cd_name INT NOT NULL, cd_taxsup INT NOT NULL, cd_ref INT NOT NULL, rank VARCHAR(255) NOT NULL, lb_name VARCHAR(255) NOT NULL, lb_author VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, valid_name VARCHAR(255) NOT NULL, vernacular_name VARCHAR(255) NOT NULL, vernacular_name_eng VARCHAR(255) NOT NULL, france VARCHAR(255) NOT NULL, french_guiana VARCHAR(255) NOT NULL, martinique VARCHAR(255) NOT NULL, guadeloupe VARCHAR(255) NOT NULL, st_martin VARCHAR(255) NOT NULL, st_barthelemy VARCHAR(255) NOT NULL, st_pierre_miquelon VARCHAR(255) NOT NULL, mayotte VARCHAR(255) NOT NULL, scattered_island VARCHAR(255) NOT NULL, reunion VARCHAR(255) NOT NULL, sub_antarctic_island VARCHAR(255) NOT NULL, adelie_land VARCHAR(255) NOT NULL, new_caledonia VARCHAR(255) NOT NULL, wallis_futuna VARCHAR(255) NOT NULL, french_polynesia VARCHAR(255) NOT NULL, clipperton VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE demand');
        $this->addSql('DROP TABLE habitat');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE observation');
        $this->addSql('DROP TABLE bird');
    }
}
