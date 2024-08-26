<?php

namespace KayStrobach\Contact\SecurityCenter\Domain\Embeddable;

use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Client\Browser;
use DeviceDetector\Parser\OperatingSystem;
use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Annotations as Flow;

/**
 * @ORM\Embeddable()
 */
class DeviceEmbeddable
{
    /**
     * @var string
     */
    protected string $clientFamily = '';

    /**
     * @var string
     */
    protected string $clientVersion = '';

    /**
     * @var string
     */
    protected string $clientEngine = '';

    /**
     * @var string
     */
    protected string $osFamily = '';

    /**
     * @var string
     */
    protected string $osInfo = '';

    /**
     * @var string
     */
    protected string $osVersion = '';

    /**
     * @var string
     */
    protected string $deviceName = '';

    /**
     * @var string
     */
    protected string $brandName = '';

    /**
     * @var string
     */
    protected string $model = '';

    protected ?bool $bot = null;

    public static function createFromEnvironment(): self
    {
        $de = new self();
        $de->initFromEnvironment();
        return $de;
    }

    public function initFromEnvironment(): void
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse
        $clientHints = ClientHints::factory($_SERVER); // client hints are optional
        $dd = new DeviceDetector($userAgent, $clientHints);
        $dd->setYamlParser(new \DeviceDetector\Yaml\Symfony());

        $dd->parse();

        $this->clientFamily = Browser::getBrowserFamily($dd->getClient('name'));
        $this->clientVersion = $dd->getClient('version');
        $this->clientEngine = $dd->getClient('engine');
        $this->osFamily = OperatingSystem::getOsFamily($dd->getOs('name'));
        $this->osVersion = $dd->getOs('version');
        $this->deviceName = $dd->getDeviceName();
        $this->brandName = $dd->getBrandName();
        $this->model = $dd->getModel();
        $this->bot = $dd->isBot();

    }

    public function getClientFamily(): string
    {
        return $this->clientFamily;
    }

    public function setClientFamily(string $clientFamily): void
    {
        $this->clientFamily = $clientFamily;
    }

    public function getClientVersion(): string
    {
        return $this->clientVersion;
    }

    public function setClientVersion(string $clientVersion): void
    {
        $this->clientVersion = $clientVersion;
    }

    public function getClientEngine(): string
    {
        return $this->clientEngine;
    }

    public function setClientEngine(string $clientEngine): void
    {
        $this->clientEngine = $clientEngine;
    }

    public function getOsInfo(): string
    {
        return $this->osInfo;
    }

    public function setOsInfo(string $osInfo): void
    {
        $this->osInfo = $osInfo;
    }

    public function getOsFamily(): string
    {
        return $this->osFamily;
    }

    public function setOsFamily(string $osFamily): void
    {
        $this->osFamily = $osFamily;
    }

    public function getOsVersion(): string
    {
        return $this->osVersion;
    }

    public function setOsVersion(string $osVersion): void
    {
        $this->osVersion = $osVersion;
    }

    public function getDeviceName(): string
    {
        return $this->deviceName;
    }

    public function setDeviceName(string $deviceName): void
    {
        $this->deviceName = $deviceName;
    }

    public function getBrandName(): string
    {
        return $this->brandName;
    }

    public function setBrandName(string $brandName): void
    {
        $this->brandName = $brandName;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getBot(): ?bool
    {
        return $this->bot;
    }

    public function setBot(?bool $bot): void
    {
        $this->bot = $bot;
    }
}
