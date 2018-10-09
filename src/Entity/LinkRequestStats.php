<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkRequestStatsRepository")
 */
class LinkRequestStats
{
    const MOBILE_DEVICE = 'mobile';
    const TABLET_DEVICE = 'tablet';
    const DESKTOP_DEVICE = 'desktop';
    const UNKNOWN_DEVICE = 'unknown';

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="ShortLink", inversedBy="stats")
     * @ORM\JoinColumn(name="short_link_id", referencedColumnName="id", nullable=false)
     */
    private $shortLink;

    /**
     * @ORM\Column(name="ip", type="string", length=45)
     */
    private $ip;

    /**
     * @ORM\Column(name="device", type="string", columnDefinition="ENUM('mobile', 'tablet', 'desktop', 'unknown')")
     */
    private $device;

    /**
     * @ORM\Column(name="referer", type="text")
     */
    private $referer;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getShortLink()
    {
        return $this->shortLink;
    }

    /**
     * @param mixed $shortLink
     */
    public function setShortLink($shortLink)
    {
        $this->shortLink = $shortLink;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param mixed $device
     */
    public function setDevice($device)
    {
        if ($this->isInvalidDevice($device)) {
            throw new \InvalidArgumentException("Invalid device");
        }

        $this->device = $device;
    }

    private function isInvalidDevice($device) {
        return !in_array($device, [
            self::MOBILE_DEVICE,
            self::TABLET_DEVICE,
            self::DESKTOP_DEVICE,
            self::UNKNOWN_DEVICE
        ]);
    }

    /**
     * @return mixed
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * @param mixed $referer
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    }
}