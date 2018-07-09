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

    /**
     * @var Tag
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Tag", mappedBy="user")
     */
    private $tags;

    /**
     * @var Folder
     * @ORM\OneToMany(targetEntity="MainBundle\Entity\Folder", mappedBy="user")
     */
    private $folders;

    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \DateTime('now');
        $this->bookmarks = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->folders = new ArrayCollection();
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

    /**
     * @return Tag
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
        return $this;
    }

    /**
     * @param Tag $tag
     * @return $this|bool
     */
    public function removeTag(Tag $tag)
    {
        if($this->tags->removeElement($tag)) {
            return $this;
        }
        return false;
    }

    /**
     * @return Folder
     */
    public function getFolders()
    {
        return $this->folders;
    }

    /**
     * @param Folder $folder
     * @return $this
     */
    public function addFolder(Folder $folder)
    {
        $this->folders->add($folder);
        return $this;
    }

    /**
     * @param Folder $folder
     * @return $this|bool
     */
    public function removeFolder(Folder $folder)
    {
        if($this->folders->removeElement($folder)) {
            return $this;
        }
        return false;
    }
}