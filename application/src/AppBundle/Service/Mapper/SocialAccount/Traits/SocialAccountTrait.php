<?php

namespace AppBundle\Service\Mapper\SocialAccount\Traits;

use AppBundle\Service\Mapper\SocialAccount\Interfaces\SocialAccountMapperInterface;

trait SocialAccountTrait
{

    public function attachSocialAccount(SocialAccountMapperInterface $social)
    {
        foreach ($social as $field => $value) {
            $propertySetter = 'set' . \ucfirst($field);
            if (\method_exists($this, $propertySetter) && $field !== 'id') {
                $this->$propertySetter($value);
            }
        }
    }

}