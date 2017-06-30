<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Category;

/**
 * CategoryType
 *
 * @ORM\Table(name="category_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryTypeRepository")
 */
class CategoryType
{
    /**
     * Flags for what is tracked in the category
     * IF multiple flags, most significant per least
     */
    const PERSON = 1;
    const PHRASE = 2;
    const COUNT  = 4;

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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="flags", type="integer")
     */
    private $flags;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="type")
     */
    private $categories;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SeasonTypeEntry", mappedBy="type")
     */
    private $ste;

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
     * Set flags
     *
     * @param integer $flags
     *
     * @return CategoryType
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Get flags
     *
     * @return int
     */
    public function getFlags()
    {
        return $this->flags;
    }
    /**
     * Constructor
     */
    public function __construct($title = null, $flags = null)
    {
        if ($title) {
            $this->title = $title;
        }
        if ($flags) {
            $this->flags = $flags;
        }
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return CategoryType
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return CategoryType
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
     * Get string representation of Entity
     *
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

    /**
     * Add ste
     *
     * @param \AppBundle\Entity\SeasonTypeEntry $ste
     *
     * @return CategoryType
     */
    public function addSte(\AppBundle\Entity\SeasonTypeEntry $ste)
    {
        $this->ste[] = $ste;

        return $this;
    }

    /**
     * Remove ste
     *
     * @param \AppBundle\Entity\SeasonTypeEntry $ste
     */
    public function removeSte(\AppBundle\Entity\SeasonTypeEntry $ste)
    {
        $this->ste->removeElement($ste);
    }

    /**
     * Get ste
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSte()
    {
        return $this->ste;
    }

    public function isCount()
    {
        return $this->flags & $this::COUNT;
    }

    public function isBadged()
    {
        return $this->isCount() || (($this->flags & ($this::PERSON|$this::PHRASE)) == ($this::PERSON|$this::PHRASE));
    }
}
