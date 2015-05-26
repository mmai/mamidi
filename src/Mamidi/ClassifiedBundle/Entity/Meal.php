<?php

namespace Mamidi\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Meal
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Meal
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
     * @ORM\ManyToOne(targetEntity="Mamidi\UserBundle\Entity\HostUser", inversedBy="meals")
     * @ORM\JoinColumn(name="host_id", referencedColumnName="id")
     */
    protected $host;

    /**
     * @ORM\OneToMany(targetEntity="Mamidi\ClassifiedBundle\Entity\Reservation", mappedBy="meal")
     */
    protected $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="starter", type="string", length=255)
     */
    private $starter;

    /**
     * @var string
     *
     * @ORM\Column(name="maincourse", type="string", length=255)
     */
    private $maincourse;

    /**
     * @var string
     *
     * @ORM\Column(name="dessert", type="string", length=255)
     */
    private $dessert;

    /**
     * @var integer
     *
     * @ORM\Column(name="numberOfGuests", type="smallint")
     */
    private $numberOfGuests;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;


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
     * Set starter
     *
     * @param string $starter
     * @return Meal
     */
    public function setStarter($starter)
    {
        $this->starter = $starter;

        return $this;
    }

    /**
     * Get starter
     *
     * @return string 
     */
    public function getStarter()
    {
        return $this->starter;
    }

    /**
     * Set maincourse
     *
     * @param string $maincourse
     * @return Meal
     */
    public function setMaincourse($maincourse)
    {
        $this->maincourse = $maincourse;

        return $this;
    }

    /**
     * Get maincourse
     *
     * @return string 
     */
    public function getMaincourse()
    {
        return $this->maincourse;
    }

    /**
     * Set dessert
     *
     * @param string $dessert
     * @return Meal
     */
    public function setDessert($dessert)
    {
        $this->dessert = $dessert;

        return $this;
    }

    /**
     * Get dessert
     *
     * @return string 
     */
    public function getDessert()
    {
        return $this->dessert;
    }

    /**
     * Set numberOfGuests
     *
     * @param integer $numberOfGuests
     * @return Meal
     */
    public function setNumberOfGuests($numberOfGuests)
    {
        $this->numberOfGuests = $numberOfGuests;

        return $this;
    }

    /**
     * Get numberOfGuests
     *
     * @return integer 
     */
    public function getNumberOfGuests()
    {
        return $this->numberOfGuests;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return Meal
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }


    /**
     * Set host
     *
     * @param \Mamidi\UserBundle\Entity\HostUser $host
     * @return Meal
     */
    public function setHost(\Mamidi\UserBundle\Entity\HostUser $host = null)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return \Mamidi\UserBundle\Entity\HostUser 
     */
    public function getHost()
    {
        return $this->host;
    }


    /**
     * Add reservations
     *
     * @param \Mamidi\ClassifiedBundle\Entity\Reservation $reservations
     * @return Meal
     */
    public function addReservation(\Mamidi\ClassifiedBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;

        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \Mamidi\ClassifiedBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\Mamidi\ClassifiedBundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}