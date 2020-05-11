<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200511011811 extends AbstractMigration
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
        $this->addSql('CREATE TABLE pais (id INT AUTO_INCREMENT NOT NULL, moneda_id INT NOT NULL, ubicacion_id INT NOT NULL, nombre_esn_espaniol VARCHAR(255) NOT NULL, nombre_en_ingles VARCHAR(255) NOT NULL, codigo_iso VARCHAR(255) NOT NULL, INDEX IDX_7E5D2EFFB77634D2 (moneda_id), UNIQUE INDEX UNIQ_7E5D2EFF57E759E8 (ubicacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pais_idioma (pais_id INT NOT NULL, idioma_id INT NOT NULL, INDEX IDX_84B2CC604D5C6 (pais_id), INDEX IDX_84B2CDEDC0611 (idioma_id), PRIMARY KEY(pais_id, idioma_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pais_horario (pais_id INT NOT NULL, horario_id INT NOT NULL, INDEX IDX_D92BB37EC604D5C6 (pais_id), INDEX IDX_D92BB37E4959F1BA (horario_id), PRIMARY KEY(pais_id, horario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horario (id INT AUTO_INCREMENT NOT NULL, zona_horaria VARCHAR(255) NOT NULL, hora TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consulta_geolocalizacion (id INT AUTO_INCREMENT NOT NULL, pais_id INT NOT NULL, ips LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', codigo_isopais VARCHAR(255) NOT NULL, distancia_desde_bs_as NUMERIC(7, 2) NOT NULL, cantidad_invocaciones INT NOT NULL, UNIQUE INDEX UNIQ_41727FBCC604D5C6 (pais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ubicacion (id INT AUTO_INCREMENT NOT NULL, latitud NUMERIC(5, 2) NOT NULL, longitud NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pais ADD CONSTRAINT FK_7E5D2EFFB77634D2 FOREIGN KEY (moneda_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE pais ADD CONSTRAINT FK_7E5D2EFF57E759E8 FOREIGN KEY (ubicacion_id) REFERENCES ubicacion (id)');
        $this->addSql('ALTER TABLE pais_idioma ADD CONSTRAINT FK_84B2CC604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pais_idioma ADD CONSTRAINT FK_84B2CDEDC0611 FOREIGN KEY (idioma_id) REFERENCES idioma (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pais_horario ADD CONSTRAINT FK_D92BB37EC604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pais_horario ADD CONSTRAINT FK_D92BB37E4959F1BA FOREIGN KEY (horario_id) REFERENCES horario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consulta_geolocalizacion ADD CONSTRAINT FK_41727FBCC604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pais DROP FOREIGN KEY FK_7E5D2EFFB77634D2');
        $this->addSql('ALTER TABLE pais_idioma DROP FOREIGN KEY FK_84B2CDEDC0611');
        $this->addSql('ALTER TABLE pais_idioma DROP FOREIGN KEY FK_84B2CC604D5C6');
        $this->addSql('ALTER TABLE pais_horario DROP FOREIGN KEY FK_D92BB37EC604D5C6');
        $this->addSql('ALTER TABLE consulta_geolocalizacion DROP FOREIGN KEY FK_41727FBCC604D5C6');
        $this->addSql('ALTER TABLE pais_horario DROP FOREIGN KEY FK_D92BB37E4959F1BA');
        $this->addSql('ALTER TABLE pais DROP FOREIGN KEY FK_7E5D2EFF57E759E8');
        $this->addSql('DROP TABLE moneda');
        $this->addSql('DROP TABLE idioma');
        $this->addSql('DROP TABLE pais');
        $this->addSql('DROP TABLE pais_idioma');
        $this->addSql('DROP TABLE pais_horario');
        $this->addSql('DROP TABLE horario');
        $this->addSql('DROP TABLE consulta_geolocalizacion');
        $this->addSql('DROP TABLE ubicacion');
    }
}
