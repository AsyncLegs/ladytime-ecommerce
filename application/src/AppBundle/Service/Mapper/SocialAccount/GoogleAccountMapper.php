<?php

namespace AppBundle\Service\Mapper\SocialAccount;

use AppBundle\Service\Mapper\SocialAccount\Interfaces\SocialAccountMapperInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class GoogleAccountMapper extends SocialAccountMapper
{

    public $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function parse(UserResponseInterface $response): SocialAccountMapperInterface
    {
        parent::parse($response);
        $this->firstName = $response->getResponse()['given_name'];
        $this->lastName = $response->getResponse()['family_name'];
        $this->username = $response->getResponse()['name'];
        $this->email = $response->getResponse()['email'];

        return $this;
    }
}