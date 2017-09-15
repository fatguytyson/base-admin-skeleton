<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 */
class Page
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
     * @ORM\Column(name="page_name", type="string", length=255, unique=true)
     */
    private $pageName;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="bgImage", type="string", length=255, nullable=true)
     */
    private $bgImage;

    /**
     * @var string
     *
     * @ORM\Column(name="header", type="string", length=255, nullable=true)
     */
    private $header;

    /**
     * @var string
     *
     * @ORM\Column(name="subheader", type="string", length=255, nullable=true)
     */
    private $subheader;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="flags", type="string", length=255, nullable=true)
     */
    private $flags;


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
     * Set pageName
     *
     * @param string $pageName
     *
     * @return Page
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * Get pageName
     *
     * @return string
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Page
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
     * Set bgImage
     *
     * @param string $bgImage
     *
     * @return Page
     */
    public function setBgImage($bgImage)
    {
        $this->bgImage = $bgImage;

        return $this;
    }

    /**
     * Get bgImage
     *
     * @return string
     */
    public function getBgImage()
    {
        return $this->bgImage;
    }

    /**
     * Set header
     *
     * @param string $header
     *
     * @return Page
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set subheader
     *
     * @param string $subheader
     *
     * @return Page
     */
    public function setSubheader($subheader)
    {
        $this->subheader = $subheader;

        return $this;
    }

    /**
     * Get subheader
     *
     * @return string
     */
    public function getSubheader()
    {
        return $this->subheader;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set flags
     *
     * @param string $flags
     *
     * @return Page
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Get flags
     *
     * @return string
     */
    public function getFlags()
    {
        return $this->flags;
    }
}

