<?php

namespace App\EventListener;


use App\Event\OutOfStockEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class OutOfStockListener
 */
class OutOfStockSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * OutOfStockSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            OutOfStockEvent::NAME => [
                ["onOutOfStockEvent", 0],
            ],
        ];
    }

    /**
     * @param OutOfStockEvent $outOfStockEvent
     */
    public function onOutOfStockEvent(OutOfStockEvent $outOfStockEvent)
    {
        $inventoryItem = $outOfStockEvent->getInventory();
        $this->getLogger()->info('******************************************');
        $this->getLogger()->info("   ID: {$inventoryItem['id']}");
        $this->getLogger()->info(" NAME: {$inventoryItem['name']}");
        $this->getLogger()->info("STOCK: {$inventoryItem['stock']}");
        $this->getLogger()->info('******************************************');
    }
}
