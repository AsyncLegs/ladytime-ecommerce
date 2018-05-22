<?php


namespace AppBundle\Service\Mapper\SocialAccount;

use AppBundle\Service\Mapper\SocialAccount\Interfaces\SocialAccountMapperInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class InstagramAccountMapper extends SocialAccountMapper
{

    public function parse(UserResponseInterface $response): SocialAccountMapperInterface
    {
        $this->networkName = $response->getResourceOwner()->getName();

        list($this->firstName, $space, $this->lastName) = \explode(' ', $response->getResponse()['data']['full_name']);
        $this->id = $response->getResponse()['data']['id'];
        $this->username = $response->getResponse()['data']['username'];

        return $this;
    }
}