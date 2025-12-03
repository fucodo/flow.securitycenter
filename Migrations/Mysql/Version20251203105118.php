<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251203105118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1060Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1060Platform'."
        );

        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry DROP FOREIGN KEY FK_A73F0BF4616A9628');
        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry ADD webhookafterrelease VARCHAR(255) NOT NULL, ADD device_bot TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry RENAME INDEX idx_a73f0bf4616a9625 TO IDX_D78B3885616A9625');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1060Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1060Platform'."
        );

        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry DROP webhookafterrelease, DROP device_bot');
        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry RENAME INDEX idx_d78b3885616a9625 TO IDX_A73F0BF4616A9625');
    }
}
