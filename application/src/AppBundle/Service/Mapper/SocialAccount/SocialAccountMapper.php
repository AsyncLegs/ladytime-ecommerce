<?php

namespace AppBundle\Service\Mapper\SocialAccount;


use AppBundle\Service\Mapper\SocialAccount\Interfaces\SocialAccountMapperInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class SocialAccountMapper implements SocialAccountMapperInterface
{

    public $id;

    protected $networkName;

    public $username;

    public $firstName;

    public $lastName;

    public function __get($name): ?SocialAccountMapperInterface
    {
        if(\property_exists($this, $name)) {

            return $this->$$name;
        }

        return null;
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
     * @return mixed
     */
    public function getNetworkName()
    {
        return $this->networkName;
    }

    /**
     * @param mixed $networkName
     */
    public function setNetworkName($networkName)
    {
        $this->networkName = $networkName;
    }


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }


    public function parse(UserResponseInterface $response): SocialAccountMapperInterface
    {

        $this->id = $response->getResponse()['id'];
        $this->networkName = $response->getResourceOwner()->getName();

        return $this;
    }

    public static function socialAccountFactory(string $socialNetwork): SocialAccountMapperInterface
    {
        switch ($socialNetwork) {
            case self::FACEBOOK:

                return new FacebookAccountMapper();
                break;
            case self::GOOGLE:

                return new GoogleAccountMapper();
                break;

            case self::INSTAGRAM:

                return new InstagramAccountMapper();
                break;

        }
    }
}