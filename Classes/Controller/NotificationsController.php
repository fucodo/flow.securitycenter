<?php
namespace KayStrobach\Contact\SecurityCenter\Controller;

/*
 * This file is part of the KayStrobach.Contact.SecurityCenter package.
 */

use KayStrobach\Backend\Controller\AbstractPageRendererController;
use KayStrobach\Contact\SecurityCenter\Domain\Repository\ActivityLogEntryRepository;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class NotificationsController extends AbstractPageRendererController
{
    /**
     * @Flow\Inject
     * @var ActivityLogEntryRepository
     */
    protected $activityLogEntryRepository;

    /**
     * @return void
     */
    public function indexAction(): void
    {
        $this->view->assign('activityLog', $this->activityLogEntryRepository->findByCurrentlyLoggedInAccount());
    }
}
