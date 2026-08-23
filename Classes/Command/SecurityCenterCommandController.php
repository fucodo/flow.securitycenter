<?php
namespace fucodo\contact\securitycenter\Command;

use fucodo\contact\securitycenter\Domain\Repository\ActivityLogEntryRepository;
use Neos\Cache\Frontend\FrontendInterface;
use Neos\Cache\Frontend\VariableFrontend;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use Neos\Flow\ObjectManagement\DependencyInjection\DependencyProxy;

#[Flow\Scope("singleton")]
class SecurityCenterCommandController extends CommandController {

    protected null|FrontendInterface|DependencyProxy $cleanupCache = null;

    #[Flow\Inject]
    protected ActivityLogEntryRepository $activityLogEntryRepository;


    public function cleanupExpiredEntriesCommand(int $batchSize = 1000, int $maxBatches = 200): void
    {
        $totalDeleted = 0;
        for ($i = 0; $i < $maxBatches; $i++) {
            $deleted = $this->activityLogEntryRepository->deleteExpiredEntriesBatch($batchSize);
            $totalDeleted += $deleted;
            if ($deleted < $batchSize) {
                break;
            }
            usleep(50000);
        }

        $this->cleanupCache->set('lastCleanupRunAt', time());
        $this->outputLine('Deleted %d expired activity log entries.', [$totalDeleted]);
    }
}
