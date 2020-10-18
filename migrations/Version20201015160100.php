<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201015160100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement_des_entite ADD succursale_id INT NOT NULL');
        $this->addSql('ALTER TABLE departement_des_entite ADD CONSTRAINT FK_AFE73E36C4166807 FOREIGN KEY (succursale_id) REFERENCES succursale (id)');
        $this->addSql('CREATE INDEX IDX_AFE73E36C4166807 ON departement_des_entite (succursale_id)');
        $this->addSql('ALTER TABLE succursale ADD entite_id INT NOT NULL');
        $this->addSql('ALTER TABLE succursale ADD CONSTRAINT FK_BC0811939BEA957A FOREIGN KEY (entite_id) REFERENCES entite (id)');
        $this->addSql('CREATE INDEX IDX_BC0811939BEA957A ON succursale (entite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement_des_entite DROP FOREIGN KEY FK_AFE73E36C4166807');
        $this->addSql('DROP INDEX IDX_AFE73E36C4166807 ON departement_des_entite');
        $this->addSql('ALTER TABLE departement_des_entite DROP succursale_id');
        $this->addSql('ALTER TABLE succursale DROP FOREIGN KEY FK_BC0811939BEA957A');
        $this->addSql('DROP INDEX IDX_BC0811939BEA957A ON succursale');
        $this->addSql('ALTER TABLE succursale DROP entite_id');
    }
}
