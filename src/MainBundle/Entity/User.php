<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MainBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var Bookmark
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Bookmark", mappedBy="user")
     */
    private $bookmarks;

    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \DateTime();
        $this->bookmarks = new ArrayCollection();
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
     * @return User
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
}