<?php

namespace KayStrobach\Contact\SecurityCenter;

use KayStrobach\Contact\SecurityCenter\Slots\LoginSlot;
use Neos\Flow\Http\Helper\SecurityHelper;
use Neos\Flow\Package\Package as BasePackage;
use Neos\Flow\Security\Authentication\AuthenticationProviderManager;

/**
 * The Flow Package
 */
class Package extends BasePackage
{


    /**
     * Invokes custom PHP code directly after the package manager has been initialized.
     *
     * @param \Neos\Flow\Core\Bootstrap $bootstrap The current bootstrap
     * @return void
     */
    public function boot(\Neos\Flow\Core\Bootstrap $bootstrap): void
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();

        $dispatcher->connect(
            AuthenticationProviderManager::class,
            'authenticatedToken',
            LoginSlot::class,
            'trackLogin'
        );
    }
}
