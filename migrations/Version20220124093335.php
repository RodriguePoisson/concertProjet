<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220124093335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concert_artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, pseudo VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, biography VARCHAR(1000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert_band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, description VARCHAR(1000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert_band_concert_artist (concert_band_id INT NOT NULL, concert_artist_id INT NOT NULL, INDEX IDX_1089B9D8D3B157B1 (concert_band_id), INDEX IDX_1089B9D88D1D722A (concert_artist_id), PRIMARY KEY(concert_band_id, concert_artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert_concert (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(1000) NOT NULL, picture VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert_concert_concert_artist (concert_concert_id INT NOT NULL, concert_artist_id INT NOT NULL, INDEX IDX_FBD0B792EB2E42A8 (concert_concert_id), INDEX IDX_FBD0B7928D1D722A (concert_artist_id), PRIMARY KEY(concert_concert_id, concert_artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert_concert_concert_band (concert_concert_id INT NOT NULL, concert_band_id INT NOT NULL, INDEX IDX_877B683BEB2E42A8 (concert_concert_id), INDEX IDX_877B683BD3B157B1 (concert_band_id), PRIMARY KEY(concert_concert_id, concert_band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, last_name VARCHAR(30) DEFAULT NULL, name VARCHAR(30) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_concert_band (user_id INT NOT NULL, concert_band_id INT NOT NULL, INDEX IDX_6DAEEA2EA76ED395 (user_id), INDEX IDX_6DAEEA2ED3B157B1 (concert_band_id), PRIMARY KEY(user_id, concert_band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_concert_artist (user_id INT NOT NULL, concert_artist_id INT NOT NULL, INDEX IDX_CFD3595FA76ED395 (user_id), INDEX IDX_CFD3595F8D1D722A (concert_artist_id), PRIMARY KEY(user_id, concert_artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concert_band_concert_artist ADD CONSTRAINT FK_1089B9D8D3B157B1 FOREIGN KEY (concert_band_id) REFERENCES concert_band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concert_band_concert_artist ADD CONSTRAINT FK_1089B9D88D1D722A FOREIGN KEY (concert_artist_id) REFERENCES concert_artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concert_concert_concert_artist ADD CONSTRAINT FK_FBD0B792EB2E42A8 FOREIGN KEY (concert_concert_id) REFERENCES concert_concert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concert_concert_concert_artist ADD CONSTRAINT FK_FBD0B7928D1D722A FOREIGN KEY (concert_artist_id) REFERENCES concert_artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concert_concert_concert_band ADD CONSTRAINT FK_877B683BEB2E42A8 FOREIGN KEY (concert_concert_id) REFERENCES concert_concert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concert_concert_concert_band ADD CONSTRAINT FK_877B683BD3B157B1 FOREIGN KEY (concert_band_id) REFERENCES concert_band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert_band ADD CONSTRAINT FK_6DAEEA2EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert_band ADD CONSTRAINT FK_6DAEEA2ED3B157B1 FOREIGN KEY (concert_band_id) REFERENCES concert_band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert_artist ADD CONSTRAINT FK_CFD3595FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert_artist ADD CONSTRAINT FK_CFD3595F8D1D722A FOREIGN KEY (concert_artist_id) REFERENCES concert_artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concert_band_concert_artist DROP FOREIGN KEY FK_1089B9D88D1D722A');
        $this->addSql('ALTER TABLE concert_concert_concert_artist DROP FOREIGN KEY FK_FBD0B7928D1D722A');
        $this->addSql('ALTER TABLE user_concert_artist DROP FOREIGN KEY FK_CFD3595F8D1D722A');
        $this->addSql('ALTER TABLE concert_band_concert_artist DROP FOREIGN KEY FK_1089B9D8D3B157B1');
        $this->addSql('ALTER TABLE concert_concert_concert_band DROP FOREIGN KEY FK_877B683BD3B157B1');
        $this->addSql('ALTER TABLE user_concert_band DROP FOREIGN KEY FK_6DAEEA2ED3B157B1');
        $this->addSql('ALTER TABLE concert_concert_concert_artist DROP FOREIGN KEY FK_FBD0B792EB2E42A8');
        $this->addSql('ALTER TABLE concert_concert_concert_band DROP FOREIGN KEY FK_877B683BEB2E42A8');
        $this->addSql('ALTER TABLE user_concert_band DROP FOREIGN KEY FK_6DAEEA2EA76ED395');
        $this->addSql('ALTER TABLE user_concert_artist DROP FOREIGN KEY FK_CFD3595FA76ED395');
        $this->addSql('DROP TABLE concert_artist');
        $this->addSql('DROP TABLE concert_band');
        $this->addSql('DROP TABLE concert_band_concert_artist');
        $this->addSql('DROP TABLE concert_concert');
        $this->addSql('DROP TABLE concert_concert_concert_artist');
        $this->addSql('DROP TABLE concert_concert_concert_band');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_concert_band');
        $this->addSql('DROP TABLE user_concert_artist');
    }
}
