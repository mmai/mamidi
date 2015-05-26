<?php

namespace Mamidi\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Reservation
{
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
     * @var boolean
     *
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated;


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
     * @param boolean $status
     * @return Reservation
     */
    public function setValidated($validated)
    {
        $this->status = $validated;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
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
