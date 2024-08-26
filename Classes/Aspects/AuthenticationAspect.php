<?php

namespace fucodo\contact\securitycenter\Aspects;

use fucodo\contact\securitycenter\Domain\Model\ActivityLogEntry;
use fucodo\contact\securitycenter\Domain\Repository\ActivityLogEntryRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Doctrine\PersistenceManager;
use Neos\Flow\Security\Account;
use Neos\Flow\Security\Context;

/**
 * @Flow\Aspect
 */
class AuthenticationAspect
{
    /**
     * The security context of the current request
     *
     * @Flow\Inject
     * @var Context
     */
    protected $securityContext;

    /**
     * @Flow\Inject
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @Flow\Around("method(Neos\Flow\Security\Authentication\AuthenticationProviderManager->logout())")
     */

    public function trackLogout(\Neos\Flow\AOP\JoinPointInterface $joinPoint)
    {
        $identity = 'anonymous';
        if ($this->securityContext->getAccount() instanceof Account) {
            $identity = $this->securityContext->getAccount()->getAccountIdentifier();
        }

        $log = new ActivityLogEntry();
        $log->setTitle('Logout');
        $log->setSeverity(ActivityLogEntry::SEVERITY_OK);
        $log->setUserIdentity($identity);
        $this->persistenceManager->allowObject($log);
        $this->persistenceManager->add($log);
        $this->persistenceManager->persistAllowedObjects();

        return $joinPoint->getAdviceChain()->proceed($joinPoint);
    }
}
