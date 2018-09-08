<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Options
 *
 * @ORM\Table(name="options")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\OptionsRepository")
 */
class Options
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
     * @var bool
     *
     * @ORM\Column(name="multimediaEnabled", type="boolean")
     */
    private $multimediaEnabled;


    public function __construct()
    {
        $this->multimediaEnabled = false;
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
     * Set multimediaEnabled
     *
     * @param boolean $multimediaEnabled
     *
     * @return Options
     */
    public function setMultimediaEnabled($multimediaEnabled)
    {
        $this->multimediaEnabled = $multimediaEnabled;

        return $this;
    }

    /**
     * Get multimediaEnabled
     *
     * @return bool
     */
    public function getMultimediaEnabled()
    {
        return $this->multimediaEnabled;
    }
}

