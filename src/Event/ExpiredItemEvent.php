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
     * @var InventoryModel $item
     */
    protected $item;

    /**
     * ExpiredItemEvent constructor.
     * @param InventoryModel $item
     */
    public function __construct(InventoryModel $item)
    {
        $this->item = $item;
    }

    /**
     * @return InventoryModel
     */
    public function getExpiredItem(): InventoryModel
    {
        return $this->item;
    }
}
