<?php

namespace AppBundle\Service\Security;

class ResetPassword
{
    public function isTokenValid($token): boolean
    {
        return false;
    }

    public function generateToken()
    {
        return hash_pbkdf2('sha512', \uniqid(\md5(\mt_rand()), true), 100, 64);

    }

}