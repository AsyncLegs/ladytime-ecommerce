<?php

namespace AppBundle\Service\Mapper\Currency;

use AppBundle\DTO\Private24CurrencyDTO;
use AppBundle\Service\Mapper\Currency\Interfaces\CurrencyMapperInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Private24CurrencyDTOMapper implements CurrencyMapperInterface
{
    public function hydrate(array $currencies): ArrayCollection
    {
        $result = new ArrayCollection();
        foreach ($currencies as $currency) {
            $result->add(new Private24CurrencyDTO($currency->ccy, $currency->base_ccy, $currency->sale));
        }

        return $result;
    }

}