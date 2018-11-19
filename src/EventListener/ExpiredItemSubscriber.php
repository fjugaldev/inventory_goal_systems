<?php

namespace App\EventListener;


use App\Event\ExpiredItemEvent;
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
        $expiredItem = $expiredItemEvent->getExpiredItem();
        $this->getLogger()->info('******************************************');
        $this->getLogger()->info("        ID: {$expiredItem['id']}");
        $this->getLogger()->info("      NAME: {$expiredItem['name']}");
        $this->getLogger()->info("EXPIRED AT: {$expiredItem['expireAt']}");
        $this->getLogger()->info('******************************************');
    }
}
