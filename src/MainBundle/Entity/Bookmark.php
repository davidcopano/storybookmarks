<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * Bookmark
 *
 * @ORM\Table(name="bookmark")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\BookmarkRepository")
 */
class Bookmark
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\User", inversedBy="bookmarks")
     */
    private $user;

    /**
     * @var Tag
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Tag", inversedBy="bookmark")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $tag;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var Folder
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Folder", inversedBy="bookmarks")
     * @JoinColumn(name="folder_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $folder;

    /**
     * @var boolean
     * @ORM\Column(name="public", type="boolean", nullable=true)
     */
    private $public;

    /**
     * @var \DateTime
     * @ORM\Column(name="expiration_date", type="datetime", nullable=true, options={"comment":"Expiration date if public bookmark"})
     */
    private $expirationDate;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
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
     * Set title
     *
     * @param string $title
     *
     * @return Bookmark
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Bookmark
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Bookmark
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
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
     * @return Bookmark
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return Folder
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param Folder $folder
     * @return Bookmark
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return Bookmark
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param Tag $tag
     * @return Bookmark
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @param bool $public
     * @return Bookmark
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $expirationDate
     * @return Bookmark
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return bool
     * Check if actual bookmark is a valid public bookmark
     */
    public function checkValidPublic() {
        $todayDatetime = new \DateTime();
        if($this->isPublic() && $this->getExpirationDate() > $todayDatetime ) {
            return true;
        }
        return false;
    }

    public function isUrl_aImage() {
        $extensions = ['ase', 'art', 'bmp', 'blp', 'cd5', 'cit', 'cpt', 'cr2', 'cut', 'dds', 'dib', 'djvu', 'egt', 'exif', 'gif', 'gpl', 'grf', 'icns', 'ico', 'iff', 'jng', 'jpeg', 'jpg', 'jfif', 'jp2', 'jps', 'lbm', 'max', 'miff', 'mng', 'msp', 'nitf', 'ota', 'pbm', 'pc1', 'pc2', 'pc3', 'pcf', 'pcx', 'pdn', 'pgm', 'PI1', 'PI2', 'PI3', 'pict', 'pct', 'pnm', 'pns', 'ppm', 'psb', 'psd', 'pdd', 'psp', 'px', 'pxm', 'pxr', 'qfx', 'raw', 'rle', 'sct', 'sgi', 'rgb', 'int', 'bw', 'tga', 'tiff', 'tif', 'vtf', 'xbm', 'xcf', 'xpm', '3dv', 'amf', 'ai', 'awg', 'cgm', 'cdr', 'cmx', 'dxf', 'e2d', 'egt', 'eps', 'fs', 'gbr', 'odg', 'svg', 'stl', 'vrml', 'x3d', 'sxd', 'v2d', 'vnd', 'wmf', 'emf', 'art', 'xar', 'png', 'webp', 'jxr', 'hdp', 'wdp', 'cur', 'ecw', 'iff', 'lbm', 'liff', 'nrrd', 'pam', 'pcx', 'pgf', 'sgi', 'rgb', 'rgba', 'bw', 'int', 'inta', 'sid', 'ras', 'sun', 'tga'];
        foreach ($extensions as $extension) {
            if($this->getUrlExtension() === $extension) {
                return true;
            }
        }
        return false;
    }

    public function isUrl_aVideo() {
        $extensions = ['3g2', '3gp', 'aaf', 'asf', 'avchd', 'avi', 'drc', 'flv', 'm2v', 'm4p', 'm4v', 'mkv', 'mng', 'mov', 'mp2', 'mp4', 'mpe', 'mpeg', 'mpg', 'mpv', 'mxf', 'nsv', 'ogg', 'ogv', 'qt', 'rm', 'rmvb', 'roq', 'svi', 'vob', 'webm', 'wmv', 'yuv'];
        foreach ($extensions as $extension) {
            if($this->getUrlExtension() === $extension) {
                return true;
            }
        }
        return false;
    }

    private function getUrlExtension() {
        $array = explode('.', $this->getUrl());
        return strtolower(end($array));
    }
}

