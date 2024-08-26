<?php

namespace fucodo\contact\securitycenter\Slots;

use fucodo\contact\securitycenter\Domain\Model\ActivityLogEntry;
use fucodo\contact\securitycenter\Domain\Repository\ActivityLogEntryRepository;
use Neos\Flow\Persistence\Doctrine\PersistenceManager;
use Neos\Flow\Security\Authentication\TokenInterface;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Security\Context;

class LoginSlot
{
    /**
     * @Flow\Inject
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * The security context of the current request
     *
     * @Flow\Inject
     * @var Context
     */
    protected $securityContext;

    public function trackLogin(TokenInterface $token): void
    {
        $identifier = $token->getAccount()->getAccountIdentifier();
        $log = new ActivityLogEntry();
        $log->setTitle('Login');
        $log->setSeverity(ActivityLogEntry::SEVERITY_NOTICE);
        $log->setUserIdentity($identifier);
        $this->persistenceManager->allowObject($log);
        $this->persistenceManager->add($log);
        $this->persistenceManager->persistAllowedObjects();
    }
}
