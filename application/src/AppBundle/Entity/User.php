<?php

namespace AppBundle\Entity;

use AppBundle\Service\Mapper\SocialAccount\SocialAccountMapper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use libphonenumber\PhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 * @UniqueEntity(fields="phone", message="Phone already taken")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\NotBlank(groups={"register", "update"})
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255,  nullable=true, unique=true)
     * @Assert\NotBlank(groups={"register"})
     * @Assert\Email(groups={"register", "update"}, checkMX=true)
     */
    protected $email;

    /**
     * @var PhoneNumber
     * @ORM\Column(name="phone", type="phone_number", unique=true)
     * @Assert\NotBlank(groups={"register", "update"})
     * @AssertPhoneNumber(defaultRegion="UA", type="mobile", groups={"register", "update"})
     */
    protected $phone;


    /**
     * @Assert\NotBlank(groups={"register"})
     * @Assert\Length(min="5", max=4096, groups={"register"})
     */
    protected $plainPassword;


    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=64)
     */
    protected $password;

    /**
     * @var string
     */
    protected $salt;


    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role")
     * @ORM\JoinTable(name="users_roles", joinColumns={@ORM\JoinColumn(name="user_id",
     *     referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     */
    protected $userRoles;

    /**
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    protected $facebookId;

    /**
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    protected $googleId;

    /**
     * @ORM\Column(name="instagram_id", type="string", length=255, nullable=true)
     */
    protected $instagramId;

    /**
     * @var Profile
     * @ORM\OneToOne(targetEntity="Profile", cascade={"persist"})
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    protected $profile;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->salt = \password_hash(uniqid(mt_rand(), true), \CRYPT_BLOWFISH);
        $this->profile = new Profile();
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
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(?string $email)
    {
        $this->email = $email;
    }

    /**
     * @return PhoneNumber
     */
    public function getPhone(): ?PhoneNumber
    {


        return $this->phone;
    }

    /**
     * @param PhoneNumber $phone
     * @return $this
     */
    public function setPhone(PhoneNumber $phone)
    {
        $this->phone = $phone;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param mixed $facebookId
     * @return $this
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @param mixed $googleId
     * @return $this
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getInstagramId()
    {
        return $this->instagramId;
    }

    /**
     * @param mixed $instagramId
     * @return $this
     */
    public function setInstagramId($instagramId)
    {
        $this->instagramId = $instagramId;

        return $this;

    }

    /**
     * @return Profile
     */
    public function getProfile(): Profile
    {
        return $this->profile;
    }

    /**
     * @param Profile $profile
     * @return $this
     */
    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;

        return $this;

    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;

    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;

    }

    /**
     * @return \DateTime
     */
    public function getLastLogin(): \DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     * @return $this
     */
    public function setLastLogin(\DateTime $lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function setSocialNetwork(SocialAccountMapper $socialAccount)
    {
        $this->setEmail($socialAccount->email ?: null);
        $this->setUsername($socialAccount->username ?: null);

        if (!empty($socialAccount->getNetworkName())) {
            $setter = "set" . \ucfirst($socialAccount->getNetworkName()) . "Id";
            $this->$setter($socialAccount->getId());
        }

    }


    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
            ) = unserialize($serialized);
    }

    public function getUserRoles()
    {
        return $this->userRoles;
    }

    public function setUserRoles(ArrayCollection $roles)
    {
        $this->userRoles = $roles;
    }

    public function addRole(Role $role)
    {
        $this->userRoles->add($role);

        return $this;
    }
    public function getRoles()
    {

        return $this->userRoles->toArray();
    }


    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username = '')
    {
        $this->username = $username;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime('now');
    }

    public function __toString(): string
    {
        return $this->getUsername() ?? "";
    }

}
