<?php

namespace KayStrobach\Contact\SecurityCenter\Domain\Embeddable;
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


}
