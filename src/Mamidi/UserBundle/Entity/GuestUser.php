<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 22/05/15
 * Time: 16:07
 */

namespace Mamidi\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_guest")
 * @UniqueEntity(fields = "username", targetClass = "Mamidi\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Mamidi\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class GuestUser extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your mobile phone number.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=10,
     *     max="15",
     *     minMessage="The phone number is too short.",
     *     maxMessage="The phone number is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $phone;

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
     * Set phone
     *
     * @param string $phone
     * @return GuestUser
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
}
