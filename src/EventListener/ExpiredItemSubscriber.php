<?php

namespace App\EventListener;


use App\Event\ExpiredItemEvent;
use App\Model\InventoryModel;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ExpiredItemListener
 */
class ExpiredItemSubscriber implements EventSubscriberInterface
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
            ExpiredItemEvent::NAME => [
                ["onExpiredItemEvent", 0],
            ],
        ];
    }

    /**
     * @param ExpiredItemEvent $expiredItemEvent
     */
    public function onExpiredItemEvent(ExpiredItemEvent $expiredItemEvent)
    {
        /** @var InventoryModel $expiredItem */
        $expiredItem = $expiredItemEvent->getExpiredItem();
        $this->getLogger()->info('******************** EXPIRED ITEM *********************');
        $this->getLogger()->info("        ID: {$expiredItem->getId()}");
        $this->getLogger()->info("      NAME: {$expiredItem->getName()}");
        $this->getLogger()->info("EXPIRED AT: {$expiredItem->getExpireAt()}");
        $this->getLogger()->info('*******************************************************');
    }
}
