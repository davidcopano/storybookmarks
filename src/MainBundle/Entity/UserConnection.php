<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserConnection
 *
 * @ORM\Table(name="user_connection")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\UserConnectionRepository")
 */
class UserConnection
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="operating_system", type="string", length=255)
     */
    private $operatingSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="browser", type="string", length=255)
     */
    private $browser;

    /**
     * @var string
     *
     * @ORM\Column(name="device", type="string", length=255)
     */
    private $device;

    /**
     * @var string
     *
     * @ORM\Column(name="user_agent", type="string", length=255)
     */
    private $userAgent;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User", inversedBy="userConnections")
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return UserConnection
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set operatingSystem
     *
     * @param string $operatingSystem
     *
     * @return UserConnection
     */
    public function setOperatingSystem($operatingSystem)
    {
        $this->operatingSystem = $operatingSystem;

        return $this;
    }

    /**
     * Get operatingSystem
     *
     * @return string
     */
    public function getOperatingSystem()
    {
        return $this->operatingSystem;
    }

    /**
     * Set browser
     *
     * @param string $browser
     *
     * @return UserConnection
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;

        return $this;
    }

    /**
     * Get browser
     *
     * @return string
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Set device
     *
     * @param string $device
     *
     * @return UserConnection
     */
    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device
     *
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set userAgent
     *
     * @param string $userAgent
     *
     * @return UserConnection
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return UserConnection
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}

