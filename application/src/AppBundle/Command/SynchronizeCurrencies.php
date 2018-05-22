<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SynchronizeCurrencies extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('ladytime.store:synchronize-currencies')
            ->setDescription('Fires event in the queue for currencies synchronizing');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');
        $queue = $this->getContainer()->get("leezy.pheanstalk");

        $logger->info(\sprintf('Job for currency synchronization with ID: %d, has been added',
            $queue
                ->useTube('ladytime.currencies')
                ->put('currency.synchronize'))
        );



    }
}