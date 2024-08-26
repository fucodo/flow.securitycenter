<?php
namespace fucodo\contact\securitycenter\Domain\Repository;

/*
 * This file is part of the KayStrobach.Contact.SecurityCenter package.
 */

use fucodo\contact\securitycenter\Domain\Model\ActivityLogEntry;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\QueryInterface;
use Neos\Flow\Persistence\QueryResultInterface;
use Neos\Flow\Persistence\Repository;
use Neos\Flow\Security\Account;
use Neos\Flow\Security\Context;

/**
 * @Flow\Scope("singleton")
 */
class ActivityLogEntryRepository extends Repository
{
    /**
     * The security context of the current request
     *
     * @Flow\Inject
     * @var Context
     */
    protected $securityContext;

    protected $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING
    ];

    public function findByCurrentlyLoggedInAccount(): ?QueryResultInterface
    {
        $accountIdentifier = $this->securityContext?->getAccount()?->getAccountIdentifier();
        if ($accountIdentifier === null) {
            return null;
        }
        return $this->findByUser($accountIdentifier);
    }

    public function findByUser(string $accountIdentifier): QueryResultInterface
    {
        $q = $this->createQuery();
        $q->matching(
            $q->equals('userIdentity', $accountIdentifier)
        );
        return $q->execute();
    }

    public function create(string $severity, string $title, string $code = '', string $message = '', bool $userApproval = false, bool $adminApproval = false): ActivityLogEntry
    {
        $identity = 'anonymous';
        if ($this->securityContext->getAccount() instanceof Account) {
            $identity = $this->securityContext->getAccount()->getAccountIdentifier();
        }

        $log = new ActivityLogEntry();
        $log->setSeverity($severity);
        $log->setTitle($title);
        $log->setCode($code);
        $log->setMessage($message);
        $log->getAdminApproval()->setNeeded($adminApproval);
        $log->getUserApproval()->setNeeded($userApproval);
        $log->setSeverity(ActivityLogEntry::SEVERITY_NOTICE);
        $log->setUserIdentity($identity);

        $this->add($log);

        return $log;
    }

    public function createWarning(string $title, string $code = '', string $message = '', bool $userApproval = false, bool $adminApproval = false): ActivityLogEntry
    {
        return $this->create(ActivityLogEntry::SEVERITY_WARNING, $title, $code, $message, $userApproval, $adminApproval);
    }

    public function createError(string $title, string $code = '', string $message = '', bool $userApproval = false, bool $adminApproval = false): ActivityLogEntry
    {
        return $this->create(ActivityLogEntry::SEVERITY_ERROR, $title, $code, $message, $userApproval, $adminApproval);
    }

    public function createNotice(string $title, string $code = '', string $message = '', bool $userApproval = false, bool $adminApproval = false): ActivityLogEntry
    {
        return $this->create(ActivityLogEntry::SEVERITY_NOTICE, $title, $code, $message, $userApproval, $adminApproval);
    }

    public function createOk(string $title, string $code = '', string $message = '', bool $userApproval = false, bool $adminApproval = false): ActivityLogEntry
    {
        return $this->create(ActivityLogEntry::SEVERITY_OK, $title, $code, $message, $userApproval, $adminApproval);
    }

    public function add($object): void
    {
        $this->persistenceManager->allowObject($object);
        parent::add($object);
        $this->persistenceManager->persistAllowedObjects();
    }

    public function update($object): void
    {
        $this->persistenceManager->allowObject($object);
        parent::update($object);
        $this->persistenceManager->persistAllowedObjects();
    }

    public function deleteExpiredEntries(): void
    {

    }
}
