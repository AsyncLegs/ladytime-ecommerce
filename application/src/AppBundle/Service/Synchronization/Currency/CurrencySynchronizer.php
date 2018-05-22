<?php

namespace AppBundle\Service\Synchronization\Currency;

use AppBundle\Entity\Currency;
use AppBundle\Service\Mapper\Currency\Private24CurrencyDTOMapper;
use AppBundle\Service\Synchronization\Interfaces\ReceiverInterface;
use AppBundle\Service\Synchronization\Interfaces\SynchronizeInterface;
use Doctrine\ORM\EntityManagerInterface;

class CurrencySynchronizer implements SynchronizeInterface
{
    private $em;
    private $currencyReceiver;

    /**
     * CurrencySynchronizer constructor.
     * @param EntityManagerInterface $em
     * @param ReceiverInterface $currencyReceiver
     */
    public function __construct(EntityManagerInterface $em, ReceiverInterface $currencyReceiver)
    {
        $this->em = $em;
        $this->currencyReceiver = $currencyReceiver;
    }

    /**
     *
     */
    public function synchronize()
    {
        $currencies = $this->currencyReceiver->getReceived();

        $currencyDTOCollection = (new Private24CurrencyDTOMapper())->hydrate($currencies);

        $currentCurrencyRepo = $this->em->getRepository('AppBundle:Currency');

        foreach ($currencyDTOCollection as $key => $item) {

            $currentCurrency = ($currentCurrencyRepo->findByName($item->getName()));
            if (empty($currentCurrency)) {
                $currency = $item->getCurrency();
                if (null !== $currency && $currency instanceof Currency) {
                    $this->em->persist($currency);
                }
            } else {
                $currentCurrency->setValue($item->getValue());
                $this->em->merge($currentCurrency);
            }
        }
        $this->em->flush();
    }
}
