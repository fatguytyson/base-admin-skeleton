<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="profile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 */
class Profile
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="truck", type="string", length=255, nullable=true)
     */
    private $truck;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @var string|null
     *
     * @ORM\Column(name="stripeUser", type="string", length=255, nullable=true, unique=true)
     */
    private $stripeUser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="profile")
	 */
    private $user;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rating", mappedBy="target")
	 */
    private $ratings;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rating", mappedBy="submitter")
	 */
    private $myRatings;

    public function __construct()
    {
    	$this->ratings   = new ArrayCollection();
    	$this->myRatings = new ArrayCollection();
    }

	/**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Profile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone.
     *
     * @param string $phone
     *
     * @return Profile
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set truck.
     *
     * @param string $truck
     *
     * @return Profile
     */
    public function setTruck($truck)
    {
        $this->truck = $truck;

        return $this;
    }

    /**
     * Get truck.
     *
     * @return string
     */
    public function getTruck()
    {
        return $this->truck;
    }

    /**
     * Set location.
     *
     * @param string $location
     *
     * @return Profile
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set stripeUser.
     *
     * @param string|null $stripeUser
     *
     * @return Profile
     */
    public function setStripeUser($stripeUser = null)
    {
        $this->stripeUser = $stripeUser;

        return $this;
    }

    /**
     * Get stripeUser.
     *
     * @return string|null
     */
    public function getStripeUser()
    {
        return $this->stripeUser;
    }

    /**
     * Set rating.
     *
     * @param int|null $rating
     *
     * @return Profile
     */
    public function setRating($rating = null)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating.
     *
     * @return int|null
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Add rating.
     *
     * @param \AppBundle\Entity\Rating $rating
     *
     * @return Profile
     */
    public function addRating(\AppBundle\Entity\Rating $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating.
     *
     * @param \AppBundle\Entity\Rating $rating
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeRating(\AppBundle\Entity\Rating $rating)
    {
        return $this->ratings->removeElement($rating);
    }

    /**
     * Get ratings.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Add myRating.
     *
     * @param \AppBundle\Entity\Rating $myRating
     *
     * @return Profile
     */
    public function addMyRating(\AppBundle\Entity\Rating $myRating)
    {
        $this->myRatings[] = $myRating;

        return $this;
    }

    /**
     * Remove myRating.
     *
     * @param \AppBundle\Entity\Rating $myRating
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMyRating(\AppBundle\Entity\Rating $myRating)
    {
        return $this->myRatings->removeElement($myRating);
    }

    /**
     * Get myRatings.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyRatings()
    {
        return $this->myRatings;
    }
}
