<?php

namespace App\Model;


/**
 * Class InventoryModel
 */
class InventoryModel
{
    /** @var int */
    protected $id;
    /** @var string */
    protected $sku;
    /** @var string */
    protected $name;
    /** @var string */
    protected $type;
    /** @var int */
    protected $stock;
    /** @var string*/
    protected $expireAt;

    /**
     * InventoryModel constructor.
     */
    public function __construct()
    {
        $this->id       = 0;
        $this->sku      = '';
        $this->name     = '';
        $this->type     = '';
        $this->stock    = 0;
        $this->sku      = '';
        $this->expireAt = new \DateTime('1900-01-01');
    }

    /**
     * Gets Inventory ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets Inventory ID
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets Inventory SKU
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * Sets Inventory SKU
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * Gets Inventory Name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Inventory Name
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets Inventory Type
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets Inventory Type
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Gets Inventory Stock
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * Sets Inventory Stock
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * Gets Inventory Expiration
     * @return string
     */
    public function getExpireAt(): string
    {
        return $this->expireAt;
    }

    /**
     * Sets Inventory Expiration
     * @param string $expireAt
     */
    public function setExpireAt(string $expireAt): void
    {
        $this->expireAt = $expireAt;
    }

    /**
     * @return array
     */
    public function __toJson(): array
    {
        return get_object_vars($this);
    }
}
