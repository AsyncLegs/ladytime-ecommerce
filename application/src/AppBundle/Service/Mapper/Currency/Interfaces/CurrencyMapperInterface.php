<?php

namespace AppBundle\Service\Mapper\Currency\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

interface CurrencyMapperInterface
{
    public function hydrate(array $currency): ArrayCollection;

}