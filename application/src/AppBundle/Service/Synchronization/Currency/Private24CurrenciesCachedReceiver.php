<?php

namespace AppBundle\Service\Synchronization\Currency;

use AppBundle\Service\Synchronization\Interfaces\Private24ReceiverInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Private24CurrenciesCachedReceiver implements Private24ReceiverInterface
{
    private $httpClient;
    private $cachier;
    private $params;

    /**
     * Private24CurrenciesCachedReceiver constructor.
     * @param $httpClient
     * @param FilesystemAdapter $cachier
     * @param array $params
     */
    public function __construct($httpClient, FilesystemAdapter $cachier, array $params)
    {
        $this->httpClient = $httpClient;
        $this->cachier = $cachier;
        $this->params = $params;
    }

    public function getReceived():?array
    {
        $currencies = $this->cachier->getItem($this->params['cache']['key']);
        if (!$currencies->isHit()) {
            $res = $this->httpClient
                ->request('GET', $this->params['external_api_url']);
            $currencies->set(\GuzzleHttp\json_decode($res->getBody()->getContents()));
            $currencies->expiresAfter($this->params['cache']['expires']);
        }

        return $currencies->get();
    }
}