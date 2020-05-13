<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512195245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE moneda (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) NOT NULL, cotizacion_en_usd NUMERIC(10, 6) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE idioma (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, abreviacion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pais (id INT AUTO_INCREMENT NOT NULL, ubicacion_id INT NOT NULL, nombre_en_espaniol VARCHAR(255) NOT NULL, nombre_en_ingles VARCHAR(255) NOT NULL, codigo_iso VARCHAR(255) NOT NULL, zonas_horarias LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_7E5D2EFF57E759E8 (ubicacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pais_moneda (pais_id INT NOT NULL, moneda_id INT NOT NULL, INDEX IDX_ADCB3E0DC604D5C6 (pais_id), INDEX IDX_ADCB3E0DB77634D2 (moneda_id), PRIMARY KEY(pais_id, moneda_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pais_idioma (pais_id INT NOT NULL, idioma_id INT NOT NULL, INDEX IDX_84B2CC604D5C6 (pais_id), INDEX IDX_84B2CDEDC0611 (idioma_id), PRIMARY KEY(pais_id, idioma_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE geolocalizacion (id INT AUTO_INCREMENT NOT NULL, pais_id INT NOT NULL, ultima_ip_consultada VARCHAR(255) NOT NULL, ips_consultadas_por_pais LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', codigo_isopais VARCHAR(255) NOT NULL, distancia_desde_bs_as NUMERIC(7, 2) NOT NULL, cantidad_invocaciones INT NOT NULL, UNIQUE INDEX UNIQ_1D6913FC604D5C6 (pais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ubicacion (id INT AUTO_INCREMENT NOT NULL, latitud NUMERIC(5, 2) NOT NULL, longitud NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pais ADD CONSTRAINT FK_7E5D2EFF57E759E8 FOREIGN KEY (ubicacion_id) REFERENCES ubicacion (id)');
        $this->addSql('ALTER TABLE pais_moneda ADD CONSTRAINT FK_ADCB3E0DC604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pais_moneda ADD CONSTRAINT FK_ADCB3E0DB77634D2 FOREIGN KEY (moneda_id) REFERENCES moneda (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pais_idioma ADD CONSTRAINT FK_84B2CC604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pais_idioma ADD CONSTRAINT FK_84B2CDEDC0611 FOREIGN KEY (idioma_id) REFERENCES idioma (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE geolocalizacion ADD CONSTRAINT FK_1D6913FC604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pais_moneda DROP FOREIGN KEY FK_ADCB3E0DB77634D2');
        $this->addSql('ALTER TABLE pais_idioma DROP FOREIGN KEY FK_84B2CDEDC0611');
        $this->addSql('ALTER TABLE pais_moneda DROP FOREIGN KEY FK_ADCB3E0DC604D5C6');
        $this->addSql('ALTER TABLE pais_idioma DROP FOREIGN KEY FK_84B2CC604D5C6');
        $this->addSql('ALTER TABLE geolocalizacion DROP FOREIGN KEY FK_1D6913FC604D5C6');
        $this->addSql('ALTER TABLE pais DROP FOREIGN KEY FK_7E5D2EFF57E759E8');
        $this->addSql('DROP TABLE moneda');
        $this->addSql('DROP TABLE idioma');
        $this->addSql('DROP TABLE pais');
        $this->addSql('DROP TABLE pais_moneda');
        $this->addSql('DROP TABLE pais_idioma');
        $this->addSql('DROP TABLE geolocalizacion');
        $this->addSql('DROP TABLE ubicacion');
    }
}
