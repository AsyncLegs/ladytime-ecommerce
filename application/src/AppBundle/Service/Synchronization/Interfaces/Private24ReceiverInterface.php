<?php

namespace AppBundle\Service\Synchronization\Interfaces;

interface Private24ReceiverInterface extends ReceiverInterface
{
    public function getReceived(): ?array;

}