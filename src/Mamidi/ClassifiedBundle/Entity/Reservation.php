<?php

namespace Mamidi\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * Reservation
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields={"meal", "guest"})
 */
class Reservation
{
    private $statusList = Array(
        "PENDING" => "En attente",
        "ACCEPTED" => "Confirmée",
        "REJECTED" => "Rejetée"
    );

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Meal", inversedBy="reservations")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id")
     */
    protected $meal;

    /**
     * @ORM\ManyToOne(targetEntity="Mamidi\UserBundle\Entity\GuestUser", inversedBy="reservations")
     * @ORM\JoinColumn(name="guest_id", referencedColumnName="id")
     */
    private $guest;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @Assert\Choice(choices = {"PENDING", "ACCEPTED", "REJECTED"})
     *
     * @ORM\Column(name="status", type="text")
     */
    private $status = "PENDING";

    /**
    * @ORM\Column(name="formula", type="text")
    */
    private $formula = "complete";

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
     * Set date
     *
     * @param \DateTime $date
     * @return Reservation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set status
     *
     * @param text $status
     * @return Reservation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set formula
     *
     * @param text $formula
     * @return Reservation
     */
    public function setFormula($formula)
    {
        $this->formula = $formula;

        return $this;
    }

    /**
     * Get formula
     *
     * @return string
     */
    public function getFormula()
    {
        return $this->formula;
    }

    public function displayStatus(){
        return $this->statusList[$this->status];
    }

    /**
     * Set meal
     *
     * @param \Mamidi\ClassifiedBundle\Entity\Meal $meal
     * @return Reservation
     */
    public function setMeal(\Mamidi\ClassifiedBundle\Entity\Meal $meal = null)
    {
        $this->meal = $meal;

        return $this;
    }

    /**
     * Get meal
     *
     * @return \Mamidi\ClassifiedBundle\Entity\Meal 
     */
    public function getMeal()
    {
        return $this->meal;
    }

    /**
     * Set guest
     *
     * @param \Mamidi\UserBundle\Entity\GuestUser $guest
     * @return Reservation
     */
    public function setGuest(\Mamidi\UserBundle\Entity\GuestUser $guest = null)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Get guest
     *
     * @return \Mamidi\UserBundle\Entity\GuestUser 
     */
    public function getGuest()
    {
        return $this->guest;
    }
}
