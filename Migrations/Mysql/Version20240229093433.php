<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229093433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1027Platform'."
        );

        $this->addSql('ALTER TABLE kaystrobach_contact_securitycenter_domain_model_activityl_21769 ADD device_clientinfo VARCHAR(255) NOT NULL, ADD device_clientfamily VARCHAR(255) NOT NULL, ADD device_osinfo VARCHAR(255) NOT NULL, ADD device_osfamily VARCHAR(255) NOT NULL, ADD device_devicename VARCHAR(255) NOT NULL, ADD device_brandname VARCHAR(255) NOT NULL, ADD device_model VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1027Platform'."
        );

        $this->addSql('ALTER TABLE kaystrobach_contact_securitycenter_domain_model_activityl_21769 DROP device_clientinfo, DROP device_clientfamily, DROP device_osinfo, DROP device_osfamily, DROP device_devicename, DROP device_brandname, DROP device_model');
    }
}
