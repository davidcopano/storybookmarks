<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PublicBookmark
 *
 * @ORM\Table(name="public_bookmark")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\PublicBookmarkRepository")
 */
class PublicBookmark
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration_date", type="datetime", nullable=true)
     */
    private $expirationDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var Bookmark
     * @ORM\OneToOne(targetEntity="MainBundle\Entity\Bookmark")
     * @ORM\JoinColumn(name="bookmark_id", referencedColumnName="id")
     */
    private $bookmark;

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
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     *
     * @return PublicBookmark
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return PublicBookmark
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return Bookmark
     */
    public function getBookmark()
    {
        return $this->bookmark;
    }

    /**
     * @param Bookmark $bookmark
     * @return PublicBookmark
     */
    public function setBookmark($bookmark)
    {
        $this->bookmark = $bookmark;
        return $this;
    }
}

