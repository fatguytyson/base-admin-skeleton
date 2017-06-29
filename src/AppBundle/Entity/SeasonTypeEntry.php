<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Season;
use AppBundle\Entity\CategoryType;
use AppBundle\Entity\Entry;

/**
 * SeasonTypeEntry
 *
 * @ORM\Table(name="season_type_entry")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeasonTypeEntryRepository")
 */
class SeasonTypeEntry
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
     * @var Season
     *
     * @ORM\ManyToOne(targetEntity="Season")
     * @ORM\JoinColumn(name="season", referencedColumnName="id")
     */
    private $season;

    /**
     * @var CategoryType
     *
     * @ORM\ManyToOne(targetEntity="CategoryType", inversedBy="ste")
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
     */
    private $type;

    /**
     * @var Entry
     *
     * @ORM\ManyToOne(targetEntity="Entry")
     * @ORM\JoinColumn(name="entry", referencedColumnName="id")
     */
    private $entry;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CategorySTEData", mappedBy="ste")
     */
    private $csd;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set season
     *
     * @param \AppBundle\Entity\Season $season
     *
     * @return SeasonTypeEntry
     */
    public function setSeason(\AppBundle\Entity\Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return \AppBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\CategoryType $type
     *
     * @return SeasonTypeEntry
     */
    public function setType(\AppBundle\Entity\CategoryType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\CategoryType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set entry
     *
     * @param \AppBundle\Entity\Entry $entry
     *
     * @return SeasonTypeEntry
     */
    public function setEntry(\AppBundle\Entity\Entry $entry = null)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return \AppBundle\Entity\Entry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Get string representation of Entity
     *
     * @return string
     */
    public function __toString()
    {
        return $this->season.$this->type.$this->entry;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->csd = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add csd
     *
     * @param \AppBundle\Entity\CategorySTEData $csd
     *
     * @return SeasonTypeEntry
     */
    public function addCsd(\AppBundle\Entity\CategorySTEData $csd)
    {
        $this->csd[] = $csd;

        return $this;
    }

    /**
     * Remove csd
     *
     * @param \AppBundle\Entity\CategorySTEData $csd
     */
    public function removeCsd(\AppBundle\Entity\CategorySTEData $csd)
    {
        $this->csd->removeElement($csd);
    }

    /**
     * Get csd
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCsd()
    {
        return $this->csd;
    }
}
