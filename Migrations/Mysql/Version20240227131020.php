<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240227131020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySqlPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySqlPlatform'."
        );

        $this->addSql('CREATE TABLE kaystrobach_contact_securitycenter_domain_model_activityl_21769 (persistence_object_identifier VARCHAR(40) NOT NULL, parentlogentry VARCHAR(40) DEFAULT NULL, createdat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expiresat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', useridentity VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, severity VARCHAR(255) NOT NULL, source VARCHAR(255) NOT NULL, sourceidentifier VARCHAR(255) NOT NULL, user_approval_needed TINYINT(1) NOT NULL, user_approval_doneat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', user_approval_doneby VARCHAR(255) NOT NULL, user_approval_signaluri VARCHAR(255) NOT NULL, admin_approval_needed TINYINT(1) NOT NULL, admin_approval_doneat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', admin_approval_doneby VARCHAR(255) NOT NULL, admin_approval_signaluri VARCHAR(255) NOT NULL, netword_address_ipadress VARCHAR(255) NOT NULL, netword_address_resolvedhostnames VARCHAR(255) NOT NULL, user_requested_support_needed TINYINT(1) NOT NULL, user_requested_support_doneat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', user_requested_support_doneby VARCHAR(255) NOT NULL, user_requested_support_signaluri VARCHAR(255) NOT NULL, INDEX IDX_A73F0BF4616A9625 (parentlogentry), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kaystrobach_contact_securitycenter_domain_model_activityl_21769 ADD CONSTRAINT FK_A73F0BF4616A9625 FOREIGN KEY (parentlogentry) REFERENCES kaystrobach_contact_securitycenter_domain_model_activityl_21769 (persistence_object_identifier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySqlPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySqlPlatform'."
        );

        $this->addSql('DROP TABLE kaystrobach_contact_securitycenter_domain_model_activityl_21769');
    }
}
