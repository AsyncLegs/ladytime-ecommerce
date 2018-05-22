<?php

namespace AppBundle\Service\Mapper\SocialAccount\Interfaces;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

interface SocialAccountMapperInterface
{
    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';
    const INSTAGRAM = 'instagram';

    public function parse(UserResponseInterface $response): SocialAccountMapperInterface;
}