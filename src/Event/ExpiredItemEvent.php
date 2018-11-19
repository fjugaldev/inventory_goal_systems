<?php

namespace App\Event;


use App\Model\InventoryModel;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ExpiredItemEvent
 */
class ExpiredItemEvent extends Event
{
    /**
     * Sets the name for the event
     */
    const NAME = "event.inventory.expired_item";

    /**
     * @var array $item
     */
    protected $item;

    /**
     * ExpiredItemEvent constructor.
     * @param array $item
     */
    public function __construct(array $item)
    {
        $this->item = $item;
    }

    /**
     * @return array
     */
    public function getExpiredItem(): array
    {
        return $this->item;
    }
}
