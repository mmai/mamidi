<?php

namespace Mamidi\ClassifiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank
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
        $this->time = new \DateTime();
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
     * @var boolean
     *
     * @ORM\Column(name="formula_maincourse", type="boolean")
     */
    private $formulaMainCourse = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="formula_starter_maincourse", type="boolean")
     */
    private $formulaStarterMainCourse = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="formula_maincourse_dessert", type="boolean")
     */
    private $formulaMainCourseDessert = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="formula_complete", type="boolean")
     */
    private $formulaComplete = true;

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

    public function getAvailableSeats(){
        $criteria = Criteria::create()->where(Criteria::expr()->eq("status", "ACCEPTED"));
        $confirmedReservations = $this->getReservations()->matching($criteria);

        return $this->getNumberOfGuests() - $confirmedReservations->count();
    }

    /**
     * Check if a meal is booked by a guest
     *
     * @param \Mamidi\UserBundle\Entity\GuestUser $guest
     * @return Boolean
     */
    public function isBookedBy($guest)
    {
        return $this->reservations->exists(function($key, $reservation) use($guest) {
            return $reservation->getGuest() == $guest;
        });
    }

    /**
     * Check if a meal is booked by a guest and if the reservation has been confirmed by the host
     *
     * @param \Mamidi\UserBundle\Entity\GuestUser $guest
     * @return Boolean
     */
    public function isConfirmedFor($guest)
    {
        return $this->reservations->exists(function($key, $reservation) use($guest) {
            return ($reservation->getGuest() == $guest) and ($reservation->getStatus() == "ACCEPTED");
        });
    }

    /**
     * Display the meal location information according to the status of the guest reservation
     * @param $guest
     * @return string
     */
    public function displayLocationFor($user){
        $host = $this->getHost();
        $location = $host->getAddress();
        //We show an aproximate location if the reservation has not been confirmed
        if (($user != $host) && (!$this->isConfirmedFor($user)) ){
            $location = $this->blurAddress($location);
        }
        return $location;
    }

    /**
     * Blur an address : give an approximate location
     * @param $address the exact address
     * @return String a blured address without the number of the place
     */
    private function blurAddress($address)
    {
        return preg_replace('/^[^\d]*\d+[,\s]*/', '', $address);
    }

    public function enableFormula($formula)
    {
        switch($formula) {
            case "maincourse":
                $this->setFormulaMainCourse(true);
                break;
            case "starter_maincourse":
                $this->setFormulaStarterMainCourse(true);
                break;
            case "maincourse_dessert":
                $this->setFormulaMainCourseDessert(true);
                break;
            case "complete":
                $this->setFormulaComplete(true);
                break;
        }
    }


    public function disableFormula($formula)
    {
        switch($formula) {
            case "maincourse":
                $this->setFormulaMainCourse(false);
                break;
            case "starter_maincourse":
                $this->setFormulaStarterMainCourse(false);
                break;
            case "maincourse_dessert":
                $this->setFormulaMainCourseDessert(false);
                break;
            case "complete":
                $this->setFormulaComplete(false);
                break;
        }
    }

    public function getFormulas()
    {
        $formulas = array();
        if ($this->formulaComplete) array_push($formulas, "complete");
        if ($this->formulaMainCourse) array_push($formulas, "maincourse");
        if ($this->formulaStarterMainCourse) array_push($formulas, "starter_maincourse");
        if ($this->formulaMainCourseDessert) array_push($formulas, "maincourse_dessert");
        return $formulas;
    }

    /**
     * Set formulaMainCourse
     *
     * @param boolean $formulaMainCourse
     * @return Meal
     */
    public function setFormulaMainCourse($formulaMainCourse)
    {
        $this->formulaMainCourse = $formulaMainCourse;

        return $this;
    }

    /**
     * Get formulaMainCourse
     *
     * @return boolean 
     */
    public function getFormulaMainCourse()
    {
        return $this->formulaMainCourse;
    }

    /**
     * Set formulaStarterMainCourse
     *
     * @param boolean $formulaStarterMainCourse
     * @return Meal
     */
    public function setFormulaStarterMainCourse($formulaStarterMainCourse)
    {
        $this->formulaStarterMainCourse = $formulaStarterMainCourse;

        return $this;
    }

    /**
     * Get formulaStarterMainCourse
     *
     * @return boolean 
     */
    public function getFormulaStarterMainCourse()
    {
        return $this->formulaStarterMainCourse;
    }

    /**
     * Set formulaMainCourseDessert
     *
     * @param boolean $formulaMainCourseDessert
     * @return Meal
     */
    public function setFormulaMainCourseDessert($formulaMainCourseDessert)
    {
        $this->formulaMainCourseDessert = $formulaMainCourseDessert;

        return $this;
    }

    /**
     * Get formulaMainCourseDessert
     *
     * @return boolean 
     */
    public function getFormulaMainCourseDessert()
    {
        return $this->formulaMainCourseDessert;
    }

    /**
     * Set formulaComplete
     *
     * @param boolean $formulaComplete
     * @return Meal
     */
    public function setFormulaComplete($formulaComplete)
    {
        $this->formulaComplete = $formulaComplete;

        return $this;
    }

    /**
     * Get formulaComplete
     *
     * @return boolean 
     */
    public function getFormulaComplete()
    {
        return $this->formulaComplete;
    }
}
