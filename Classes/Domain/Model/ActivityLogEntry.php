<?php

namespace fucodo\contact\securitycenter\Domain\Model;

use DateTimeImmutable;
use fucodo\contact\securitycenter\Domain\Embeddable\ApprovalEmbeddable;
use fucodo\contact\securitycenter\Domain\Embeddable\DeviceEmbeddable;
use fucodo\contact\securitycenter\Domain\Embeddable\NetworkAddressEmbeddable;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class ActivityLogEntry
{
    public const SEVERITY_NOTICE = 'Notice';
    public const SEVERITY_WARNING = 'Warning';
    public const SEVERITY_ERROR = 'Error';
    public const SEVERITY_OK = 'OK';

    /**
     * @var DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var DateTimeImmutable
     */
    protected $expiresAt;

    /**
     * @var string
     */
    protected $userIdentity;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $code = '';

    /**
     * One of
     *
     * const SEVERITY_NOTICE = 'Notice';
     * const SEVERITY_WARNING = 'Warning';
     * const SEVERITY_ERROR = 'Error';
     * const SEVERITY_OK = 'OK';
     *
     * @var string
     */
    protected $severity = self::SEVERITY_WARNING;

    /**
     * @ORM\Embedded(columnPrefix="user_approval_")
     * @var ApprovalEmbeddable
     */
    protected $userApproval;

    /**
     * @ORM\Embedded(columnPrefix="admin_approval_")
     * * @var ApprovalEmbeddable
     */
    protected $adminApproval;

    /**
     * @ORM\Embedded(columnPrefix="netword_address_")
     * @var NetworkAddressEmbeddable
     */
    protected $networkAddress;

    /**
     * @ORM\Embedded(columnPrefix="device_")
     * @var DeviceEmbeddable
     */
    protected $device;

    /**
     * @var ?string
     */
    protected $source = 'internal';

    /**
     * @var ?string
     */
    protected $sourceIdentifier = '';

    /**
     * @ORM\ManyToOne()
     * @var ActivityLogEntry
     */
    protected $parentLogEntry;

    /**
     * -> sends email, when requested by user
     * @ORM\Embedded(columnPrefix="user_requested_support_")
     * @var ApprovalEmbeddable
     */
    protected $userRequestedCheckBySupport;

    protected string $webHookAfterRelease = '';

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->userApproval = new ApprovalEmbeddable();
        $this->adminApproval = new ApprovalEmbeddable();
        $this->userRequestedCheckBySupport = new ApprovalEmbeddable();
        $this->expiresAt = new \DateTimeImmutable('+3 months');

        $this->networkAddress = NetworkAddressEmbeddable::createFromEnvironment();
        $this->device = DeviceEmbeddable::createFromEnvironment();
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAtAge(): \DateInterval
    {
        $now = new \DateTimeImmutable('now');
        return $this->createdAt->diff($now);
    }

    public function getCreatedAtAgeDays(): string
    {
        return $this->getCreatedAtAge()->format('%R%d');
    }

    public function getDateForGroupBy(): string
    {
        return $this->createdAt->format('d.m.Y');
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTimeImmutable $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getUserIdentity(): string
    {
        return $this->userIdentity;
    }

    public function setUserIdentity(string $userIdentity): void
    {
        $this->userIdentity = $userIdentity;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getSeverity(): string
    {
        return $this->severity;
    }

    public function setSeverity(string $severity): void
    {
        $this->severity = $severity;
    }

    public function getUserApproval(): DeviceEmbeddable|ApprovalEmbeddable
    {
        return $this->userApproval;
    }

    public function setUserApproval(DeviceEmbeddable|ApprovalEmbeddable $userApproval): void
    {
        $this->userApproval = $userApproval;
    }

    public function getAdminApproval(): DeviceEmbeddable|ApprovalEmbeddable
    {
        return $this->adminApproval;
    }

    public function setAdminApproval(DeviceEmbeddable|ApprovalEmbeddable $adminApproval): void
    {
        $this->adminApproval = $adminApproval;
    }

    public function getNetworkAddress(): NetworkAddressEmbeddable
    {
        return $this->networkAddress;
    }

    public function setNetworkAddress(NetworkAddressEmbeddable $networkAddress): void
    {
        $this->networkAddress = $networkAddress;
    }

    public function getDevice(): DeviceEmbeddable
    {
        return $this->device;
    }

    public function setDevice(DeviceEmbeddable $device): void
    {
        $this->device = $device;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): void
    {
        $this->source = $source;
    }

    public function getSourceIdentifier(): ?string
    {
        return $this->sourceIdentifier;
    }

    public function setSourceIdentifier(?string $sourceIdentifier): void
    {
        $this->sourceIdentifier = $sourceIdentifier;
    }

    public function getParentLogEntry(): ?ActivityLogEntry
    {
        return $this->parentLogEntry;
    }

    public function setParentLogEntry(?ActivityLogEntry $parentLogEntry): void
    {
        $this->parentLogEntry = $parentLogEntry;
    }

    public function getUserRequestedCheckBySupport(): ApprovalEmbeddable
    {
        return $this->userRequestedCheckBySupport;
    }

    public function setUserRequestedCheckBySupport(ApprovalEmbeddable $userRequestedCheckBySupport): void
    {
        $this->userRequestedCheckBySupport = $userRequestedCheckBySupport;
    }

    public function getWebHookAfterRelease(): string
    {
        return $this->webHookAfterRelease;
    }

    public function setWebHookAfterRelease(string $webHookAfterRelease): void
    {
        $this->webHookAfterRelease = $webHookAfterRelease;
    }
}
