<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240227142744 extends AbstractMigration
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

        $this->addSql('ALTER TABLE kaystrobach_contact_securitycenter_domain_model_activityl_21769 CHANGE user_approval_doneat user_approval_doneat DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE admin_approval_doneat admin_approval_doneat DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE user_requested_support_doneat user_requested_support_doneat DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySqlPlatform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySqlPlatform'."
        );

        $this->addSql('ALTER TABLE kaystrobach_contact_securitycenter_domain_model_activityl_21769 CHANGE user_approval_doneat user_approval_doneat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE admin_approval_doneat admin_approval_doneat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE user_requested_support_doneat user_requested_support_doneat DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
