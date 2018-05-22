<?php

namespace AppBundle\Entity;

use AppBundle\Service\Mapper\SocialAccount\Traits\SocialAccountTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="profiles")
 * @ORM\HasLifecycleCallbacks()
 */
class Profile
{

    use SocialAccountTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $lastName;


    /**
     * @var Address
     * @ORM\OneToMany(targetEntity="Address", mappedBy="profile")
     */
    protected $addresses;

    /**
     * Profile constructor.
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Profile
     */
    public function setId($id): Profile
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): ? string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Profile
     */
    public function setFirstName(string $firstName): Profile
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): ? string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Profile
     */
    public function setLastName(string $lastName): Profile
    {
        $this->lastName = $lastName;

        return $this;
    }


    /**
     * @return Address
     */
    public function getAddresses(): ? Address
    {
        return $this->addresses;
    }

    /**
     * @param Address $addresses
     * @return $this
     */
    public function setAddresses(Address $addresses)
    {
        $this->addresses->add($addresses);

        return $this;
    }




}
