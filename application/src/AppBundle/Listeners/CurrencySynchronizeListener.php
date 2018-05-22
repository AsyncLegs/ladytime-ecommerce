<?php

namespace AppBundle\Listeners;

use AppBundle\Service\Synchronization\Currency\CurrencySynchronizer;
use Leezy\PheanstalkBundle\Event\CommandEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CurrencySynchronizeListener implements EventSubscriberInterface
{
    private $currencySynchronizer;

    public function __construct(CurrencySynchronizer $currencySynchronizer)
    {
        $this->currencySynchronizer = $currencySynchronizer;
    }

    public static function getSubscribedEvents()
    {
        return [
            CommandEvent::DELETE => ['onDelete', 0],
            CommandEvent::PUT => ['onPut', 0],
        ];
    }

    public function onDelete(CommandEvent $event)
    {

    }

    public function onPut(CommandEvent $event)
    {
        $tubeUsed = $event->getPheanstalk()->listTubeUsed();
        if($tubeUsed === 'ladytime.currencies') {
            $this->currencySynchronizer->synchronize();
        }
    }
}