<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180808184317 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bird (id INT AUTO_INCREMENT NOT NULL, habitat_id INT DEFAULT NULL, france_id VARCHAR(10) DEFAULT NULL, french_guiana_id VARCHAR(10) DEFAULT NULL, martinique_id VARCHAR(10) DEFAULT NULL, guadeloupe_id VARCHAR(10) DEFAULT NULL, st_martin_id VARCHAR(10) DEFAULT NULL, st_barthelemy_id VARCHAR(10) DEFAULT NULL, st_pierre_miquelon_id VARCHAR(10) DEFAULT NULL, mayotte_id VARCHAR(10) DEFAULT NULL, scattered_island_id VARCHAR(10) DEFAULT NULL, reunion_id VARCHAR(10) DEFAULT NULL, sub_antarctic_island_id VARCHAR(10) DEFAULT NULL, adelie_land_id VARCHAR(10) DEFAULT NULL, new_caledonia_id VARCHAR(10) DEFAULT NULL, wallis_futuna_id VARCHAR(10) DEFAULT NULL, french_polynesia_id VARCHAR(10) DEFAULT NULL, clipperton_id VARCHAR(10) DEFAULT NULL, reign VARCHAR(255) NOT NULL, phylum VARCHAR(255) NOT NULL, name_class VARCHAR(255) NOT NULL, name_order VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, cd_name VARCHAR(255) NOT NULL, cd_taxsup VARCHAR(255) NOT NULL, cd_ref VARCHAR(255) NOT NULL, rank VARCHAR(255) NOT NULL, lb_name VARCHAR(255) NOT NULL, lb_author VARCHAR(255) DEFAULT NULL, fullname VARCHAR(255) NOT NULL, valid_name VARCHAR(255) NOT NULL, vernacular_name VARCHAR(255) DEFAULT NULL, vernacular_name_eng VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_A0BBAE0EAFFE2D26 (habitat_id), INDEX IDX_A0BBAE0E73504598 (france_id), INDEX IDX_A0BBAE0E14B204D9 (french_guiana_id), INDEX IDX_A0BBAE0EE38B349D (martinique_id), INDEX IDX_A0BBAE0E52C0AB2F (guadeloupe_id), INDEX IDX_A0BBAE0EA217A8F2 (st_martin_id), INDEX IDX_A0BBAE0EE614786B (st_barthelemy_id), INDEX IDX_A0BBAE0EA41F07C5 (st_pierre_miquelon_id), INDEX IDX_A0BBAE0E4B73D62D (mayotte_id), INDEX IDX_A0BBAE0EE33BC28A (scattered_island_id), INDEX IDX_A0BBAE0E4E9B7368 (reunion_id), INDEX IDX_A0BBAE0E8F8E749 (sub_antarctic_island_id), INDEX IDX_A0BBAE0ED7E4FDB8 (adelie_land_id), INDEX IDX_A0BBAE0EA33982DA (new_caledonia_id), INDEX IDX_A0BBAE0E293D16C5 (wallis_futuna_id), INDEX IDX_A0BBAE0ED30D7E42 (french_polynesia_id), INDEX IDX_A0BBAE0E96B263EF (clipperton_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0EAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E73504598 FOREIGN KEY (france_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E14B204D9 FOREIGN KEY (french_guiana_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0EE38B349D FOREIGN KEY (martinique_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E52C0AB2F FOREIGN KEY (guadeloupe_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0EA217A8F2 FOREIGN KEY (st_martin_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0EE614786B FOREIGN KEY (st_barthelemy_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0EA41F07C5 FOREIGN KEY (st_pierre_miquelon_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E4B73D62D FOREIGN KEY (mayotte_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0EE33BC28A FOREIGN KEY (scattered_island_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E4E9B7368 FOREIGN KEY (reunion_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E8F8E749 FOREIGN KEY (sub_antarctic_island_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0ED7E4FDB8 FOREIGN KEY (adelie_land_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0EA33982DA FOREIGN KEY (new_caledonia_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E293D16C5 FOREIGN KEY (wallis_futuna_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0ED30D7E42 FOREIGN KEY (french_polynesia_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E96B263EF FOREIGN KEY (clipperton_id) REFERENCES biogeographic_status (id)');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE0E813F9 FOREIGN KEY (bird_id) REFERENCES bird (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE observation DROP FOREIGN KEY FK_C576DBE0E813F9');
        $this->addSql('DROP TABLE bird');
    }
}
