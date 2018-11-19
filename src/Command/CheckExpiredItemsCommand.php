<?php

namespace App\Command;

use App\Event\ExpiredItemEvent;
use PHPUnit\Runner\Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

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
        try {
            $output->writeln([
                'Verificador de items caducados en el inventario',
                '=================================================',
                '',
            ]);

            $inventory = $this->getContainer()->get('api.service.inventory_service')->getAll();
            if ($inventory['status'] === 200) {
                $expiredItems = [];
                foreach ($inventory['data'] as $item) {
                    $expireAt = new \DateTime($item['expireAt']);
                    $today = new \DateTime();

                    if ($expireAt < $today) {
                        //Dispatchs ExpiredItemEvent
                        $event = new ExpiredItemEvent($item);
                        $this->getContainer()->get('event_dispatcher')->dispatch(
                            ExpiredItemEvent::NAME,
                            $event
                        );
                        array_push($expiredItems, $item);
                    }
                }

            } else {
                $output->writeln(
                    'An error has occurred trying to get the inventory from the JSON API Server.'
                );
            }

            if (!empty($expiredItems)) {
                $output->writeln(
                    [
                        'There are expired products:',
                        '',
                    ]
                );
                foreach ($expiredItems as $expiredItem) {
                    $output->writeln(
                        [
                            '******************************************',
                            "        ID: {$expiredItem['id']}",
                            "      NAME: {$expiredItem['name']}",
                            "EXPIRED AT: {$expiredItem['expireAt']}",
                            '******************************************',
                            '',
                        ]
                    );
                }
            } else {
                $output->writeln(
                    'There are no expired products.'
                );
            }

        } catch (Exception $e) {
            $output->writeln(
                "An error has occurred trying to verify expired items for the inventory. Error: {$e->getMessage()}"
            );
        }
    }
}