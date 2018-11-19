<?php

namespace App\Service;

use App\Event\OutOfStockEvent;
use App\Model\InventoryModel;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class InventoryService
 */
class InventoryService implements BaseService
{
    /** @var ContainerInterface */
    protected $container;

    /**
     * InventoryService constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * Get Inventory Item.
     * @param int $id
     *
     * @return array
     */
    public function get(int $id): array
    {
        try {
            // Send http request to the DATA API (JSON SERVER).
            /** @var ResponseInterface $responseInterface */
            $responseInterface = $this->getHttp()->request(
                "/inventory/{$id}",
                HttpService::METHOD_GET,
                [],
                HttpService::API_DATA
            );

            // Unwrap the request body contents.
            $item = json_decode($responseInterface->getBody()->getContents());

            $inventory = new InventoryModel();
            $inventory->setId($item->id);
            $inventory->setSku($item->sku);
            $inventory->setName($item->name);
            $inventory->setType($item->type);
            $inventory->setStock($item->stock);
            $inventory->setExpireAt($item->expireAt);

            $data = $inventory->__toJson();

            // Response content.
            $response = [
                'status' => HttpService::STATUS_200,
                'data'   => $data,
            ];

        } catch (\Exception $e) {
            // Error content
            $response = [
                'status' => HttpService::STATUS_500,
                'error'  => $e->getMessage(),
            ];
        }

        // Returns the response content.
        return $response;
    }

    /**
     * Gets Inventory list.
     *
     * @return array
     */
    public function getAll(): array
    {
        try {
            // Send http request to the DATA API (JSON SERVER).
            /** @var ResponseInterface $responseInterface */
            $responseInterface = $this->getHttp()->request(
                '/inventory',
                HttpService::METHOD_GET,
                [],
                HttpService::API_DATA
            );

            // Unwrap the request body contents.
            $apiResponse = json_decode($responseInterface->getBody()->getContents());
            // Iterates the results in order to parse items into a recipe object and push it into the data array.
            $data = [];
            foreach ($apiResponse as $item) {
                // Instances a new recipe object with the item data.
                $inventory = new InventoryModel();
                $inventory->setId($item->id);
                $inventory->setSku($item->sku);
                $inventory->setName($item->name);
                $inventory->setType($item->type);
                $inventory->setStock($item->stock);
                $inventory->setExpireAt($item->expireAt);

                // Push the recipe object into the data array.
                array_push($data, $inventory->__toJson());
            }

            // Response content.
            $response = [
                'status' => HttpService::STATUS_200,
                'data'   => $data,
            ];

        } catch (\Exception $e) {
            // Error content
            $response = [
                'status' => HttpService::STATUS_500,
                'error'  => $e->getMessage(),
            ];
        }

        // Returns the response content.
        return $response;
    }

    /**
     * Adds New Inventory Item
     * @param \stdClass $parameters
     *
     * @return array
     */
    public function add(\stdClass $parameters): array
    {
        try {
            $inventory = new InventoryModel();
            $inventory->setId($parameters->id);
            $inventory->setSku($parameters->sku);
            $inventory->setName($parameters->name);
            $inventory->setType($parameters->type);
            $inventory->setStock($parameters->stock);
            $inventory->setExpireAt($parameters->expireAt);

            $responseInterface = $this->getHttp()->request(
                '/inventory',
                HttpService::METHOD_POST,
                ['form_params' => $inventory->__toJson()],
                HttpService::API_DATA
            );

            // Response content.
            $response = [
                'status' => HttpService::STATUS_200,
                'data'   => $inventory->__toJson(),
            ];

        } catch (\Exception $e) {
            // Error content
            $response = [
                'status' => HttpService::STATUS_500,
                'error'  => $e->getMessage(),
            ];
        }

        return $response;
    }

    /**
     * Edits Inventory Item
     * @param int       $id
     * @param \stdClass $parameters
     *
     * @return array
     */
    public function edit(int $id, \stdClass $parameters): array
    {
        try {
            $inventory = new InventoryModel();
            $inventory->setId($parameters->id);
            $inventory->setSku($parameters->sku);
            $inventory->setName($parameters->name);
            $inventory->setType($parameters->type);
            $inventory->setStock($parameters->stock);
            $inventory->setExpireAt($parameters->expireAt);

            $responseInterface = $this->getHttp()->request(
                "/inventory/{$id}",
                HttpService::METHOD_PUT,
                ['form_params' => $inventory->__toJson()],
                HttpService::API_DATA
            );

            // Response content.
            $response = [
                'status' => HttpService::STATUS_200,
                'data'   => $inventory->__toJson(),
            ];

        } catch (\Exception $e) {
            // Error content
            $response = [
                'status' => HttpService::STATUS_500,
                'error'  => $e->getMessage(),
            ];
        }

        return $response;
    }

    /**
     * Sets inventory item as out of stock (set stock to 0)
     * @param string $name
     *
     * @return array
     */
    public function remove(string $name): array
    {
        try {
            // Send http request to the DATA API (JSON SERVER).
            /** @var ResponseInterface $responseInterface */
            $responseInterface = $this->getHttp()->request(
                "/inventory?name={$name}",
                HttpService::METHOD_GET,
                [],
                HttpService::API_DATA
            );
            // Unwrap the request body contents.
            $item = json_decode($responseInterface->getBody()->getContents())[0];

            $inventory = new InventoryModel();
            $inventory->setId($item->id);
            $inventory->setSku($item->sku);
            $inventory->setName($item->name);
            $inventory->setType($item->type);
            $inventory->setStock(0);
            $inventory->setExpireAt($item->expireAt);

            // Edit the item inventory via http request to the DATA API (JSON SERVER).
            /** @var ResponseInterface $responseInterface */
            $responseInterface = $this->getHttp()->request(
                "/inventory/{$inventory->getId()}",
                HttpService::METHOD_PUT,
                ['form_params' => $inventory->__toJson()],
                HttpService::API_DATA
            );

            //Dispatchs outOfStock Event
            $dispatcher = new EventDispatcher();
            $event = new OutOfStockEvent($inventory);
            $dispatcher->dispatch(OutOfStockEvent::NAME, $event);

            // Response content.
            $response = [
                'status' => HttpService::STATUS_200,
                'data'   => $inventory->__toJson(),
            ];

        } catch (\Exception $e) {
            // Error content
            $response = [
                'status' => HttpService::STATUS_500,
                'error'  => $e->getMessage(),
            ];
        }

        // Returns the response content.
        return $response;
    }

    /**
     * Gets the Service Container.
     * @return ContainerInterface
     */
    private function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Sets de Service Container.
     * @param ContainerInterface $container
     *
     * @return self
     */
    private function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Gets the HttpService class.
     *
     * @return HttpService
     */
    private function getHttp(): HttpService
    {
        return $this->getContainer()->get('api.service.http_service');
    }
}
