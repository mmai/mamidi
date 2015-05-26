<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 22/05/15
 * Time: 16:05
 */

namespace Mamidi\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_host")
 * @UniqueEntity(fields = "username", targetClass = "Mamidi\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Mamidi\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class HostUser extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\OneToMany(targetEntity="Mamidi\ClassifiedBundle\Entity\Meal", mappedBy="host")
     */
    protected $meals;


    public function __construct()
    {
        parent::__construct();
        $this->meals = new ArrayCollection();
    }

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
     * Add meals
     *
     * @param \Mamidi\ClassifiedBundle\Entity\Meal $meals
     * @return HostUser
     */
    public function addMeal(\Mamidi\ClassifiedBundle\Entity\Meal $meals)
    {
        $this->meals[] = $meals;

        return $this;
    }

    /**
     * Remove meals
     *
     * @param \Mamidi\ClassifiedBundle\Entity\Meal $meals
     */
    public function removeMeal(\Mamidi\ClassifiedBundle\Entity\Meal $meals)
    {
        $this->meals->removeElement($meals);
    }

    /**
     * Get meals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMeals()
    {
        return $this->meals;
    }
}
