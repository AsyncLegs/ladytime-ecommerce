<?php
/**
 * Created by PhpStorm.
 * User: thawy
 * Date: 9/3/17
 * Time: 7:13 PM
 */

namespace AppBundle\Service\Mapper\SocialAccount;

use AppBundle\Service\Mapper\SocialAccount\Interfaces\SocialAccountMapperInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class FacebookAccountMapper extends SocialAccountMapper
{

    public function parse(UserResponseInterface $response): SocialAccountMapperInterface
    {
        parent::parse($response);
        $this->firstName = $response->getResponse()['first_name'];
        $this->lastName = $response->getResponse()['last_name'];
        $this->username = $response->getResponse()['name'];

        return $this;
    }
}