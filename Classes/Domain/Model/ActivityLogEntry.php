<?php

namespace fucodo\contact\securitycenter\Domain\Model;

use DateTimeImmutable;
use fucodo\contact\securitycenter\Domain\Embeddable\ApprovalEmbeddable;
use fucodo\contact\securitycenter\Domain\Embeddable\DeviceEmbeddable;
use fucodo\contact\securitycenter\Domain\Embeddable\NetworkAddressEmbeddable;
use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Persistence\PersistenceManagerInterface;

/**
 * @Flow\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="created_at_idx", columns={"createdAt"}),
 *         @ORM\Index(name="expires_at_idx", columns={"expiresAt"}),
 *         @ORM\Index(name="user_identity_idx", columns={"userIdentity"}),
 *         @ORM\Index(name="title_idx", columns={"title"}),
 *         @ORM\Index(name="code_idx", columns={"code"}),
 *         @ORM\Index(name="severity_idx", columns={"severity"}),
 *         @ORM\Index(name="source_identifier_idx", columns={"sourceIdentifier"})
 *     }
 * )
 */
class ActivityLogEntry implements \JsonSerializable
{
    public const SEVERITY_NOTICE = 'Notice';
    public const SEVERITY_WARNING = 'Warning';
    public const SEVERITY_ERROR = 'Error';
    public const SEVERITY_OK = 'OK';

    /**
     * date when the event happened
     *
     * @var DateTimeImmutable
     */
    protected $createdAt;

    /**
     * date, when the event expires, and then can be deleted
     *
     * @var DateTimeImmutable
     */
    protected $expiresAt;

    /**
     * the account creating the event (the one who did something)
     *
     * @var string
     */
    protected $userIdentity;

    /**
     * short description of the event
     *
     * @var string
     */
    protected $title = '';

    /**
     * more detailed description of the event
     *
     * @var string
     */
    protected $message = '';

    /**
     * internal code of the event, e.g. "user_login"
     *
     * @var string
     */
    protected $code = '';

    /**
     * declaration of the severity of the event
     *
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
     * defines if user approval is needed for the event
     * might be interesting for more serious events
     *
     * @ORM\Embedded(columnPrefix="user_approval_")
     * @var ApprovalEmbeddable
     */
    protected $userApproval;

    /**
     * defines if administrative approval is needed for the event
     * might be interesting for really serious events
     *
     * @ORM\Embedded(columnPrefix="admin_approval_")
     * * @var ApprovalEmbeddable
     */
    protected $adminApproval;

    /**
     * ip and other information regarding the network address of the user
     *
     * @ORM\Embedded(columnPrefix="netword_address_")
     * @var NetworkAddressEmbeddable
     */
    protected $networkAddress;

    /**
     * device information, e.g. browser, os, device name, etc.
     *
     * @ORM\Embedded(columnPrefix="device_")
     * @var DeviceEmbeddable
     */
    protected $device;

    /**
     * source, defines, where the event was triggered from
     * normally internally, but can be set to "external" for events triggered by external sources or other applications
     *
     * @var ?string
     */
    protected $source = 'internal';

    /**
     * identifier of the source if the source is "external"
     *
     * @var ?string
     */
    protected $sourceIdentifier = '';

    /**
     * relation to a previous event, e.g. a login event, that triggered this event
     *
     * @ORM\ManyToOne()
     * @var ActivityLogEntry
     */
    protected $parentLogEntry;

    /**
     * defines, that the users requested a check of an event by the support
     *
     * sends email, when requested by user
     *
     * @ORM\Embedded(columnPrefix="user_requested_support_")
     * @var ApprovalEmbeddable
     */
    protected $userRequestedCheckBySupport;

    /**
     * defines an endpoint, that is triggered after the event was created, approved or similar
     * @ORM\Column(type="string", length=2048, nullable=true)
     * @var ?string
     */
    protected ?string $webHookAfterRelease = '';

    /**
     * @Flow\Inject
     * @var PersistenceManagerInterface
     */
    protected $persistenceManager;

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
        $days = $this->getCreatedAtAge()->days;
        $sign = $this->getCreatedAtAge()->invert === 1 ? '-' : '+';
        return $sign . $days;
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
        if (!in_array($severity, [self::SEVERITY_OK, self::SEVERITY_NOTICE, self::SEVERITY_WARNING, self::SEVERITY_ERROR])) {
            throw new \InvalidArgumentException($severity . 'is not allowed use one of the severity constants');
        }
        $this->severity = $severity;
    }

    public function getUserApproval(): ApprovalEmbeddable
    {
        return $this->userApproval;
    }

    public function setUserApproval(ApprovalEmbeddable $userApproval): void
    {
        $this->userApproval = $userApproval;
    }

    public function getAdminApproval(): ApprovalEmbeddable
    {
        return $this->adminApproval;
    }

    public function setAdminApproval(ApprovalEmbeddable $adminApproval): void
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

    public function getWebHookAfterRelease(): ?string
    {
        return $this->webHookAfterRelease;
    }

    public function setWebHookAfterRelease(?string $webHookAfterRelease): void
    {
        $this->webHookAfterRelease = $webHookAfterRelease;
    }

    public function jsonSerialize(): array
    {
        return [
            'persistence_object_identifier' => $this->persistenceManager->getIdentifierByObject($this),
            'parentlogentry' => $this->parentLogEntry ? $this->persistenceManager->getIdentifierByObject($this->parentLogEntry) : null,
            'createdat' => $this->createdAt->format('Y-m-d H:i:s'),
            'expiresat' => $this->expiresAt->format('Y-m-d H:i:s'),
            'useridentity' => $this->userIdentity,
            'title' => $this->title,
            'message' => $this->message,
            'code' => $this->code,
            'severity' => $this->severity,
            'source' => $this->source,
            'sourceidentifier' => $this->sourceIdentifier,
            'user_approval_needed' => $this->userApproval->isNeeded() ? 1 : 0,
            'user_approval_doneat' => $this->userApproval->getDoneAt() ? $this->userApproval->getDoneAt()->format('Y-m-d H:i:s') : null,
            'user_approval_doneby' => $this->userApproval->getDoneBy(),
            'user_approval_signaluri' => $this->userApproval->getSignalUri(),
            'admin_approval_needed' => $this->adminApproval->isNeeded() ? 1 : 0,
            'admin_approval_doneat' => $this->adminApproval->getDoneAt() ? $this->adminApproval->getDoneAt()->format('Y-m-d H:i:s') : null,
            'admin_approval_doneby' => $this->adminApproval->getDoneBy(),
            'admin_approval_signaluri' => $this->adminApproval->getSignalUri(),
            'netword_address_ipadress' => $this->networkAddress->getIpAdress(),
            'netword_address_resolvedhostnames' => $this->networkAddress->getResolvedHostnames(),
            'user_requested_support_needed' => $this->userRequestedCheckBySupport->isNeeded() ? 1 : 0,
            'user_requested_support_doneat' => $this->userRequestedCheckBySupport->getDoneAt() ? $this->userRequestedCheckBySupport->getDoneAt()->format('Y-m-d H:i:s') : null,
            'user_requested_support_doneby' => $this->userRequestedCheckBySupport->getDoneBy(),
            'user_requested_support_signaluri' => $this->userRequestedCheckBySupport->getSignalUri(),
            'device_clientfamily' => $this->device->getClientFamily(),
            'device_osfamily' => $this->device->getOsFamily(),
            'device_devicename' => $this->device->getDeviceName(),
            'device_brandname' => $this->device->getBrandName(),
            'device_model' => $this->device->getModel(),
            'device_clientversion' => $this->device->getClientVersion(),
            'device_clientengine' => $this->device->getClientEngine(),
            'device_osversion' => $this->device->getOsVersion(),
            'device_osinfo' => $this->device->getOsInfo(),
        ];
    }
}
