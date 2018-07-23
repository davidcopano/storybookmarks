<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Folder
 *
 * @ORM\Table(name="folder")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\FolderRepository")
 */
class Folder
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var Bookmark
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Bookmark", mappedBy="folder")
     */
    private $bookmarks;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User", inversedBy="folders")
     */
    private $user;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->bookmarks = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Folder
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Folder
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Folder
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @param Bookmark $bookmark
     * @return $this
     */
    public function addBookmark(Bookmark $bookmark)
    {
        $this->bookmarks->add($bookmark);
        return $this;
    }

    /**
     * @param Bookmark $bookmark
     * @return $this|bool
     */
    public function removeBookmark(Bookmark $bookmark)
    {
        if($this->bookmarks->removeElement($bookmark)) {
            return $this;
        }
        return false;
    }

    /**
     * @return Bookmark
     */
    public function getBookmarks()
    {
        return $this->bookmarks;
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
     * @return Folder
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
}

