<?php

declare(strict_types=1);

namespace fucodo\contact\securitycenter\Domain\Embeddable;

use Doctrine\ORM\Mapping as ORM;
use Neos\Flow\Annotations as Flow;

/**
 * @ORM\Embeddable()
 */
class NetworkAddressEmbeddable
{
    /**
     * @var string
     */
    protected $ipAdress = '';

    /**
     * @var string
     */
    protected $resolvedHostnames = '';

    public static function createFromEnvironment(): self
    {
        $de = new self();
        $de->initFromEnvironment();
        return $de;
    }

    public function initFromEnvironment(): void
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $this->ipAdress = $ip;
        $this->resolvedHostnames = gethostbyaddr($this->ipAdress);
    }

    public function getIpAdress(): string
    {
        return $this->ipAdress;
    }

    public function setIpAdress(string $ipAdress): void
    {
        $this->ipAdress = $ipAdress;
    }

    public function getResolvedHostnames(): string
    {
        return $this->resolvedHostnames;
    }

    public function setResolvedHostnames(string $resolvedHostnames): void
    {
        $this->resolvedHostnames = $resolvedHostnames;
    }
}
