<?php

namespace LaFourchette\PagerDutyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PagerDutyEventCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('pagerduty:event')
            ->setDescription('Sends an event to Pagerduty. Usefull for testing.')
            ->addArgument('name', InputArgument::REQUIRED, 'Alias to be sent to Pagerduty')
            ->addArgument('message', InputArgument::OPTIONAL, 'Message for the event')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $message = $input->getArgument('message');

        $eventFactory = $this->getContainer()->get('la_fourchette_pager_duty.factory.event');
        $event = $eventFactory->make($name, $message);

        $event->trigger();
    }
}
