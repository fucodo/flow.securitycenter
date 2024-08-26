<?php

namespace fucodo\contact\securitycenter\Domain\Embeddable;
use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Annotations as Flow;

/**
 * @ORM\Embeddable()
 */
class ApprovalEmbeddable
{
    /**
     * @var bool
     */
    protected bool $needed = false;

    /**
     * @ORM\Column(nullable=true)
     * @var ?\DateTimeImmutable
     */
    protected ?\DateTimeImmutable $doneAt;

    /**
     * called with post and source based maschine2maschine token
     * @var string
     */
    protected string $signalUri = '';

    /**
     * @var string
     */
    protected string $doneBy = '';

    public function isNeeded(): bool
    {
        return $this->needed;
    }

    public function setNeeded(bool $needed): void
    {
        $this->needed = $needed;
    }

    public function getDoneAt(): ?\DateTimeImmutable
    {
        return $this->doneAt;
    }

    public function setDoneAt(?\DateTimeImmutable $doneAt): void
    {
        $this->doneAt = $doneAt;
    }

    public function getSignalUri(): string
    {
        return $this->signalUri;
    }

    public function setSignalUri(string $signalUri): void
    {
        $this->signalUri = $signalUri;
    }

    public function getDoneBy(): string
    {
        return $this->doneBy;
    }

    public function setDoneBy(string $doneBy): void
    {
        $this->doneBy = $doneBy;
    }
}
