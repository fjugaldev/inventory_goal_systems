<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CheckExpiredItemsCommand
 */
class CheckExpiredItemsCommand extends ContainerAwareCommand
{
    /**
     * Configure Command
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('inventory:check-expired')

            // the short description shown while running "php bin/console list"
            ->setDescription('Check expired items from the inventory.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to check what inventory items are expired and dispatch a
                notification event and print items as screen output');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);
    }
}