<?php
namespace KayStrobach\Contact\SecurityCenter\Domain\Repository;

/*
 * This file is part of the KayStrobach.Contact.SecurityCenter package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\QueryInterface;
use Neos\Flow\Persistence\QueryResultInterface;
use Neos\Flow\Persistence\Repository;
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

    public function deleteExpiredEntries(): void
    {

    }
}
