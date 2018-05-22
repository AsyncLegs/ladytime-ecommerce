<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="addresses")
 * @ORM\HasLifecycleCallbacks()
 */
class Address
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=255, nullable=false)
     */
    protected $country;

    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    protected $city;

    /**
     * @var string
     * @ORM\Column(name="address_line", type="string", length=255, nullable=false)
     */
    protected $addressLine;

    /**
     * @var string
     * @ORM\Column(name="new_post_warehouse", type="string", length=255, nullable=true)
     */
    protected $newPostWarehouse;

    /**
     * @var boolean
     * @ORM\Column(name="is_default", type="boolean", nullable=true)
     */
    protected $isDefault;

    /**
     * @var Profile
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Profile", inversedBy="addresses")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id" )
     */
    protected $profile;

}