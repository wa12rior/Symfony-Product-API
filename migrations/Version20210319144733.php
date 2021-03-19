<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210319144733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add product table with fields';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE product (id UUID NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, ptu VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN product.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE product');
    }
}
