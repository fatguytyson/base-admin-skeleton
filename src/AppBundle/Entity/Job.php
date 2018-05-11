<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobRepository")
 */
class Job
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
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255, nullable=true)
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="location", type="string", length=255)
	 */
	private $location;

	/**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255)
     */
    private $destination;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="apikey", type="string", length=255, unique=true)
     */
    private $apikey;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="completeUser", type="datetimetz", nullable=true)
     */
    private $completeUser;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="completeMember", type="datetimetz", nullable=true)
     */
    private $completeMember;

    /**
     * @var bool
     *
     * @ORM\Column(name="ratingUser", type="boolean")
     */
    private $ratingUser;

    /**
     * @var bool
     *
     * @ORM\Column(name="ratingMember", type="boolean")
     */
    private $ratingMember;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="jobsPosted")
	 */
    private $poster;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="jobsJoined")
	 * @ORM\JoinTable(name="user_jobs_joined")
	 */
    private $joined;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="jobsAccepted")
	 */
    private $accepted;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="jobsNotified")
	 * @ORM\JoinTable(name="user_jobs_notified")
	 */
    private $notified;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="jobsViewed")
	 * @ORM\JoinTable(name="user_jobs_viewed")
	 */
	private $viewed;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rating", mappedBy="job")
	 */
	private $ratings;

	public function __construct()
	{
		$this->status       = 0;
		$this->ratingUser   = false;
		$this->ratingMember = false;
		$this->joined       = new ArrayCollection();
		$this->notified     = new ArrayCollection();
		$this->viewed       = new ArrayCollection();
		$this->ratings      = new ArrayCollection();
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
     * Set title.
     *
     * @param string $title
     *
     * @return Job
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Job
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set location.
     *
     * @param string $location
     *
     * @return Job
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
     * Set destination.
     *
     * @param string $destination
     *
     * @return Job
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination.
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return Job
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set apikey.
     *
     * @param string $apikey
     *
     * @return Job
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * Get apikey.
     *
     * @return string
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return Job
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set completeUser.
     *
     * @param \DateTime|null $completeUser
     *
     * @return Job
     */
    public function setCompleteUser($completeUser = null)
    {
        $this->completeUser = $completeUser;

        return $this;
    }

    /**
     * Get completeUser.
     *
     * @return \DateTime|null
     */
    public function getCompleteUser()
    {
        return $this->completeUser;
    }

    /**
     * Set completeMember.
     *
     * @param \DateTime|null $completeMember
     *
     * @return Job
     */
    public function setCompleteMember($completeMember = null)
    {
        $this->completeMember = $completeMember;

        return $this;
    }

    /**
     * Get completeMember.
     *
     * @return \DateTime|null
     */
    public function getCompleteMember()
    {
        return $this->completeMember;
    }

    /**
     * Set ratingUser.
     *
     * @param bool $ratingUser
     *
     * @return Job
     */
    public function setRatingUser($ratingUser)
    {
        $this->ratingUser = $ratingUser;

        return $this;
    }

    /**
     * Get ratingUser.
     *
     * @return bool
     */
    public function getRatingUser()
    {
        return $this->ratingUser;
    }

    /**
     * Set ratingMember.
     *
     * @param bool $ratingMember
     *
     * @return Job
     */
    public function setRatingMember($ratingMember)
    {
        $this->ratingMember = $ratingMember;

        return $this;
    }

    /**
     * Get ratingMember.
     *
     * @return bool
     */
    public function getRatingMember()
    {
        return $this->ratingMember;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Job
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set poster.
     *
     * @param \AppBundle\Entity\User|null $poster
     *
     * @return Job
     */
    public function setPoster(\AppBundle\Entity\User $poster = null)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Add joined.
     *
     * @param \AppBundle\Entity\User $joined
     *
     * @return Job
     */
    public function addJoined(\AppBundle\Entity\User $joined)
    {
    	$joined->addJobsJoined($this);
        $this->joined[] = $joined;

        return $this;
    }

    /**
     * Remove joined.
     *
     * @param \AppBundle\Entity\User $joined
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeJoined(\AppBundle\Entity\User $joined)
    {
    	$joined->removeJobsJoined($this);
        return $this->joined->removeElement($joined);
    }

    /**
     * Get joined.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJoined()
    {
        return $this->joined;
    }

    /**
     * Set accepted.
     *
     * @param \AppBundle\Entity\User|null $accepted
     *
     * @return Job
     */
    public function setAccepted(\AppBundle\Entity\User $accepted = null)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Add notified.
     *
     * @param \AppBundle\Entity\User $notified
     *
     * @return Job
     */
    public function addNotified(\AppBundle\Entity\User $notified)
    {
    	$notified->addJobsNotified($this);
        $this->notified[] = $notified;

        return $this;
    }

    /**
     * Remove notified.
     *
     * @param \AppBundle\Entity\User $notified
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeNotified(\AppBundle\Entity\User $notified)
    {
    	$notified->removeJobsNotified($this);
        return $this->notified->removeElement($notified);
    }

    /**
     * Get notified.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotified()
    {
        return $this->notified;
    }

    /**
     * Add viewed.
     *
     * @param \AppBundle\Entity\User $viewed
     *
     * @return Job
     */
    public function addViewed(\AppBundle\Entity\User $viewed)
    {
    	$viewed->addJobsViewed($this);
        $this->viewed[] = $viewed;

        return $this;
    }

    /**
     * Remove viewed.
     *
     * @param \AppBundle\Entity\User $viewed
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeViewed(\AppBundle\Entity\User $viewed)
    {
    	$viewed->removeJobsViewed($this);
        return $this->viewed->removeElement($viewed);
    }

    /**
     * Get viewed.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getViewed()
    {
        return $this->viewed;
    }

    /**
     * Add rating.
     *
     * @param \AppBundle\Entity\Rating $rating
     *
     * @return Job
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
}
