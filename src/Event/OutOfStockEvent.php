<?php
/**
 * Created by PhpStorm.
 * User: fjugal.dev
 * Date: 19/11/2018
 * Time: 15:05
 */

namespace App\Event;


use App\Model\InventoryModel;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class OutOfStockEvent
 */
class OutOfStockEvent extends Event
{
    /**
     * Sets the name for the event
     */
    const NAME = "event.inventory.out_of_stock";

    /**
     * @var InventoryModel
     */
    protected $inventory;

    /**
     * OutOfStockEvent constructor.
     * @param InventoryModel $inventory
     */
    public function __construct(InventoryModel $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * @return InventoryModel
     */
    public function getInventory()
    {
        return $this->inventory;
    }
}