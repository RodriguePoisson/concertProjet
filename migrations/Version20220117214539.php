<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220117214539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_concert_band (user_id INT NOT NULL, concert_band_id INT NOT NULL, INDEX IDX_6DAEEA2EA76ED395 (user_id), INDEX IDX_6DAEEA2ED3B157B1 (concert_band_id), PRIMARY KEY(user_id, concert_band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_concert_artist (user_id INT NOT NULL, concert_artist_id INT NOT NULL, INDEX IDX_CFD3595FA76ED395 (user_id), INDEX IDX_CFD3595F8D1D722A (concert_artist_id), PRIMARY KEY(user_id, concert_artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_concert_band ADD CONSTRAINT FK_6DAEEA2EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert_band ADD CONSTRAINT FK_6DAEEA2ED3B157B1 FOREIGN KEY (concert_band_id) REFERENCES concert_band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert_artist ADD CONSTRAINT FK_CFD3595FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert_artist ADD CONSTRAINT FK_CFD3595F8D1D722A FOREIGN KEY (concert_artist_id) REFERENCES concert_artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_concert_band');
        $this->addSql('DROP TABLE user_concert_artist');
    }
}
