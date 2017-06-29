<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entry
 *
 * @ORM\Table(name="entry")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntryRepository")
 */
class Entry
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var EntryType
     *
     * @ORM\ManyToOne(targetEntity="EntryType", inversedBy="entries")
     * @ORM\JoinColumn(name="entry_type", referencedColumnName="id")
     */
    private $type;


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
     * @return Entry
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
     * Set type
     *
     * @param \AppBundle\Entity\EntryType $type
     *
     * @return Entry
     */
    public function setType(\AppBundle\Entity\EntryType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\EntryType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get string representation of Entity
     *
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
