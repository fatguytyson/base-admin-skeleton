<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorySTEData
 *
 * @ORM\Table(name="category_s_t_e_data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategorySTEDataRepository")
 */
class CategorySTEData
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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $category;

    /**
     * @var SeasonTypeEntry
     *
     * @ORM\ManyToOne(targetEntity="SeasonTypeEntry", inversedBy="csd")
     * @ORM\JoinColumn(name="ste", referencedColumnName="id")
     */
    private $ste;

    /**
     * @var int
     *
     * @ORM\Column(name="data", type="integer")
     */
    private $data;


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
     * Set data
     *
     * @param integer $data
     *
     * @return CategorySTEData
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return int
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return CategorySTEData
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set ste
     *
     * @param \AppBundle\Entity\SeasonTypeEntry $ste
     *
     * @return CategorySTEData
     */
    public function setSte(\AppBundle\Entity\SeasonTypeEntry $ste = null)
    {
        $this->ste = $ste;

        return $this;
    }

    /**
     * Get ste
     *
     * @return \AppBundle\Entity\SeasonTypeEntry
     */
    public function getSte()
    {
        return $this->ste;
    }

    /**
     * Get string representation of Entity
     *
     * @return string
     */
    public function __toString()
    {
        return $this->category.$this->ste;
    }
}
