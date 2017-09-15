<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questionnaire
 *
 * @ORM\Table(name="questionnaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionnaireRepository")
 */
class Questionnaire
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
     * @ORM\Column(name="issues_one", type="string", length=255)
     */
    private $issuesOne;

    /**
     * @var string
     *
     * @ORM\Column(name="issues_two", type="string", length=255)
     */
    private $issuesTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="issues_three", type="string", length=255)
     */
    private $issuesThree;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="message", type="boolean")
     */
    private $message;


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
     * Set issuesOne
     *
     * @param string $issuesOne
     *
     * @return Questionnaire
     */
    public function setIssuesOne($issuesOne)
    {
        $this->issuesOne = $issuesOne;

        return $this;
    }

    /**
     * Get issuesOne
     *
     * @return string
     */
    public function getIssuesOne()
    {
        return $this->issuesOne;
    }

    /**
     * Set issuesTwo
     *
     * @param string $issuesTwo
     *
     * @return Questionnaire
     */
    public function setIssuesTwo($issuesTwo)
    {
        $this->issuesTwo = $issuesTwo;

        return $this;
    }

    /**
     * Get issuesTwo
     *
     * @return string
     */
    public function getIssuesTwo()
    {
        return $this->issuesTwo;
    }

    /**
     * Set issuesThree
     *
     * @param string $issuesThree
     *
     * @return Questionnaire
     */
    public function setIssuesThree($issuesThree)
    {
        $this->issuesThree = $issuesThree;

        return $this;
    }

    /**
     * Get issuesThree
     *
     * @return string
     */
    public function getIssuesThree()
    {
        return $this->issuesThree;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Questionnaire
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Questionnaire
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Questionnaire
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set message
     *
     * @param boolean $message
     *
     * @return Questionnaire
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return bool
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}

