<?php

namespace App\Controller\Api;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InventoryController
 * @Route("/api/v1/inventory", name="inventory_")
 */
class InventoryController extends FOSRestController
{
    /**
     * Gets all the items on the inventory.
     * @Rest\Get("/", name="list")
     *
     * @return JsonResponse
     */
    public function listAction(): JsonResponse
    {
        // Lists the inventory.
        $response = $this->get('api.service.inventory_service')->getAll();

        // Returns a JsonResponse.
        return new JsonResponse($response, $response['status']);
    }

    /**
     * Gets a single item fom the inventory based on the item ID.
     * @Rest\Get("/{id}", name="list_item")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function listItemAction(int $id): JsonResponse
    {
        // Get the item from the inventory.
        $response = $this->get('api.service.inventory_service')->get($id);

        // Returns a JsonResponse.
        return new JsonResponse($response, $response['status']);
    }

    /**
     * Adds a new item to the inventory.
     * @Rest\Post("/", name="add_item")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addAction(Request $request): JsonResponse
    {
        $missingParameters = [];

        // TODO: The ID must be passed as parameter cause we are using a fake api json server, in a real scenarie,
        // the ID must be autonumeric.
        // Id parameter validator.
        if (!$request->request->has('id')) {
            $missingParameters[] = 'id';
        }

        // Sku parameter validator.
        if (!$request->request->has('sku')) {
            $missingParameters[] = 'sku';
        }

        // Name parameter validator.
        if (!$request->request->has('name')) {
            $missingParameters[] = 'name';
        }

        // Type parameter validator.
        if (!$request->request->has('type')) {
            $missingParameters[] = 'type';
        }

        // Stock parameter validator.
        if (!$request->request->has('stock')) {
            $missingParameters[] = 'stock';
        }

        // expireAt parameter validator.
        if (!$request->request->has('expireAt')) {
            $missingParameters[] = 'expiretAt';
        }

        if (empty($missingParameters)) {
            // Create a object of stdClass with the item properties and data.
            $parameters = new \stdClass();
            $parameters->id       = $request->request->get('id', 0);
            $parameters->sku      = $request->request->get('sku', '');
            $parameters->name     = $request->request->get('name', '');
            $parameters->type     = $request->request->get('type', '');
            $parameters->stock    = $request->request->get('stock', 0);
            $parameters->expireAt = $request->request->get('expireAt', '1900-01-01T00:00:00+00:00');

            // Send the request to the API.
            $response = $this->get('api.service.inventory_service')->add($parameters);

        } else {
            $response = [
                'status' => 500,
                'error' => [
                    'message' => 'Missing required parameters',
                    'vale' => $missingParameters,
                ],
            ];
        }

        // Return a JsonResponse.
        return new JsonResponse($response, $response['status']);
    }

    /**
     * Edits a item from the inventory.
     * @Rest\Put("/{id}", name="edit_item")
     *
     * @param int     $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function editAction(int $id, Request $request): JsonResponse
    {
        $missingParameters = [];

        // TODO: The ID must be passed as parameter cause we are using a fake api json server, in a real scenarie,
        // the ID must be autonumeric.
        // Id parameter validator.
        if (!$request->request->has('id')) {
            $missingParameters[] = 'id';
        }

        // Sku parameter validator.
        if (!$request->request->has('sku')) {
            $missingParameters[] = 'sku';
        }

        // Name parameter validator.
        if (!$request->request->has('name')) {
            $missingParameters[] = 'name';
        }

        // Type parameter validator.
        if (!$request->request->has('type')) {
            $missingParameters[] = 'type';
        }

        // Stock parameter validator.
        if (!$request->request->has('stock')) {
            $missingParameters[] = 'stock';
        }

        // expireAt parameter validator.
        if (!$request->request->has('expireAt')) {
            $missingParameters[] = 'expiretAt';
        }

        if (empty($missingParameters)) {
            // Create a object of stdClass with the item properties and data.
            $parameters = new \stdClass();
            $parameters->id       = $request->request->get('id', 0);
            $parameters->sku      = $request->request->get('sku', '');
            $parameters->name     = $request->request->get('name', '');
            $parameters->type     = $request->request->get('type', '');
            $parameters->stock    = $request->request->get('stock', 0);
            $parameters->expireAt = $request->request->get('expireAt', '1900-01-01T00:00:00+00:00');

            // Sends edit request to the API.
            $response = $this->get('api.service.inventory_service')->edit($id, $parameters);

        } else {
            $response = [
                'status' => 500,
                'error' => [
                    'message' => 'Missing required parameters',
                    'vale' => $missingParameters,
                ],
            ];
        }

        // Returns a JsonResponse.
        return new JsonResponse($response, $response['status']);
    }

    /**
     * Extracts (out of stock, set stock to 0) a item from the inventory based on the item name.
     * @Rest\Delete("/{name}", name="remove_item")
     *
     * @param string $name
     *
     * @return JsonResponse
     */
    public function removeAction(string $name): JsonResponse
    {
        // Send the remove request to the API.
        $response = $this->get('api.service.inventory_service')->remove($name);

        // Returns a JsonResponse.
        return new JsonResponse($response, $response['status']);
    }
}
