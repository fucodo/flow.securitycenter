<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260823092026 extends AbstractMigration
{
    protected const TABLE = 'fucodo_contact_securitycenter_domain_model_activitylogentry';

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

        if ($this->connection->getSchemaManager()->listTableDetails(self::TABLE)->hasForeignKey('FK_A73F0BF4616A9625')) {
            $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry DROP FOREIGN KEY FK_A73F0BF4616A9625');
        }
        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry DROP useridentity');
        $this->addSql('CREATE INDEX IF NOT EXISTS created_at_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry (createdAt)');
        $this->addSql('CREATE INDEX IF NOT EXISTS expires_at_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry (expiresAt)');
        $this->addSql('CREATE INDEX IF NOT EXISTS title_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry (title)');
        $this->addSql('CREATE INDEX IF NOT EXISTS code_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry (code)');
        $this->addSql('CREATE INDEX IF NOT EXISTS severity_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry (severity)');
        $this->addSql('CREATE INDEX IF NOT EXISTS source_identifier_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry (sourceIdentifier)');
        $this->addSql('CREATE INDEX IF NOT EXISTS contextkey_value_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry (contextKey, contextValue)');
        $this->addSql('DROP INDEX IF EXISTS idx_a73f0bf4616a9625 ON fucodo_contact_securitycenter_domain_model_activitylogentry');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_D78B3885616A9625 ON fucodo_contact_securitycenter_domain_model_activitylogentry (parentlogentry)');
        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry ADD CONSTRAINT FK_A73F0BF4616A9625 FOREIGN KEY (parentlogentry) REFERENCES fucodo_contact_securitycenter_domain_model_activitylogentry (persistence_object_identifier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDb1027Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDb1027Platform'."
        );

        $this->addSql('DROP INDEX created_at_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry');
        $this->addSql('DROP INDEX expires_at_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry');
        $this->addSql('DROP INDEX title_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry');
        $this->addSql('DROP INDEX code_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry');
        $this->addSql('DROP INDEX severity_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry');
        $this->addSql('DROP INDEX source_identifier_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry');
        $this->addSql('DROP INDEX contextkey_value_idx ON fucodo_contact_securitycenter_domain_model_activitylogentry');
        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry DROP FOREIGN KEY FK_D78B3885616A9625');
        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry ADD useridentity VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX idx_d78b3885616a9625 ON fucodo_contact_securitycenter_domain_model_activitylogentry');
        $this->addSql('CREATE INDEX IDX_A73F0BF4616A9625 ON fucodo_contact_securitycenter_domain_model_activitylogentry (parentlogentry)');
        $this->addSql('ALTER TABLE fucodo_contact_securitycenter_domain_model_activitylogentry ADD CONSTRAINT FK_D78B3885616A9625 FOREIGN KEY (parentlogentry) REFERENCES fucodo_contact_securitycenter_domain_model_activitylogentry (persistence_object_identifier)');
    }
}
