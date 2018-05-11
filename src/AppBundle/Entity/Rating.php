<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RatingRepository")
 */
class Rating
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
     * @var int
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

	/**
	 * @var Profile
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Profile", inversedBy="ratings")
	 */
    private $target;

	/**
	 * @var Profile
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Profile", inversedBy="myRatings")
	 */
    private $submitter;

	/**
	 * @var Job
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Job", inversedBy="ratings")
	 */
    private $job;


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
     * Set rate.
     *
     * @param int $rate
     *
     * @return Rating
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate.
     *
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set comment.
     *
     * @param string|null $comment
     *
     * @return Rating
     */
    public function setComment($comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set target.
     *
     * @param \AppBundle\Entity\Profile|null $target
     *
     * @return Rating
     */
    public function setTarget(\AppBundle\Entity\Profile $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target.
     *
     * @return \AppBundle\Entity\Profile|null
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set submitter.
     *
     * @param \AppBundle\Entity\Profile|null $submitter
     *
     * @return Rating
     */
    public function setSubmitter(\AppBundle\Entity\Profile $submitter = null)
    {
        $this->submitter = $submitter;

        return $this;
    }

    /**
     * Get submitter.
     *
     * @return \AppBundle\Entity\Profile|null
     */
    public function getSubmitter()
    {
        return $this->submitter;
    }

    /**
     * Set job.
     *
     * @param \AppBundle\Entity\Job|null $job
     *
     * @return Rating
     */
    public function setJob(\AppBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job.
     *
     * @return \AppBundle\Entity\Job|null
     */
    public function getJob()
    {
        return $this->job;
    }
}
