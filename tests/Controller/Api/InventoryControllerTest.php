<?php

namespace App\Tests\Controller\Api;


use App\Service\HttpService;
use FOS\RestBundle\Tests\Functional\app\AppKernel;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class InventoryControllerTest
 */
class InventoryControllerTest extends WebTestCase
{
    const API_BASE_PATH = "/api/v1/inventory";

    /** @var Client $client */
    protected $client;

    /**
     * InventoryControllerTest constructor.
     * @param null|string $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = static::createClient([
            'environment' => 'dev',
        ]);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Test for Get all inventory.
     */
    public function testListAction()
    {
        // Send the API request.
        $this->getClient()->request(
            HttpService::METHOD_GET,
            getenv('API_BASE_URI').self::API_BASE_PATH."/",
            []
        );
        $statusCode = $this->getClient()->getResponse()->getStatusCode();
        $content = json_decode($this->getClient()->getResponse()->getContent(), true);

        // Asserts for the PHPUnit tests.
        $this->assertArrayHasKey('status', $content);
        $this->assertEquals(200, $statusCode);
        $this->assertArrayHasKey('data', $content);
        if (!empty($content['data'])) {
            $this->assertArrayHasKey('id', $content['data'][0]);
            $this->assertArrayHasKey('sku', $content['data'][0]);
            $this->assertArrayHasKey('name', $content['data'][0]);
            $this->assertArrayHasKey('type', $content['data'][0]);
            $this->assertArrayHasKey('stock', $content['data'][0]);
            $this->assertArrayHasKey('expireAt', $content['data'][0]);
        }
    }

    /**
     * Test for Get single item from the inventory.
     */
    public function testListItemAction()
    {
        // Send the API request.
        $this->getClient()->request(
            HttpService::METHOD_GET,
            getenv('API_BASE_URI').self::API_BASE_PATH."/1",
            []
        );
        $statusCode = $this->getClient()->getResponse()->getStatusCode();
        $content = json_decode($this->getClient()->getResponse()->getContent(), true);

        // Asserts for the PHPUnit tests.
        $this->assertArrayHasKey('status', $content);
        $this->assertEquals(200, $statusCode);
        $this->assertArrayHasKey('data', $content);
        if (!empty($content['data'])) {
            $this->assertArrayHasKey('id', $content['data']);
            $this->assertArrayHasKey('sku', $content['data']);
            $this->assertArrayHasKey('name', $content['data']);
            $this->assertArrayHasKey('type', $content['data']);
            $this->assertArrayHasKey('stock', $content['data']);
            $this->assertArrayHasKey('expireAt', $content['data']);
        }
    }

    /**
 * Test for Get single item from the inventory.
 */
    public function testAddAction()
    {
        // Send the API request.
        $this->getClient()->request(
            HttpService::METHOD_POST,
            getenv('API_BASE_URI').self::API_BASE_PATH."/",
            [
                'id'       => '999',
                'sku'      => 'INV999',
                'name'     => 'Producto 999',
                'type'     => 'kindle',
                'stock'    => '1983',
                'expireAt' => '2019-02-12T17:34:36+00:00',
            ]
        );
        $statusCode = $this->getClient()->getResponse()->getStatusCode();
        $content = json_decode($this->getClient()->getResponse()->getContent(), true);

        // Asserts for the PHPUnit tests.
        $this->assertArrayHasKey('status', $content);
        $this->assertEquals(200, $statusCode);
        $this->assertArrayHasKey('data', $content);
        if (!empty($content['data'])) {
            $this->assertArrayHasKey('id', $content['data']);
            $this->assertArrayHasKey('sku', $content['data']);
            $this->assertArrayHasKey('name', $content['data']);
            $this->assertArrayHasKey('type', $content['data']);
            $this->assertArrayHasKey('stock', $content['data']);
            $this->assertArrayHasKey('expireAt', $content['data']);
        }
    }

    /**
     * Test for Get single item from the inventory.
     */
    public function testEditAction()
    {
        // Sends the API request.
        $this->getClient()->request(
            HttpService::METHOD_PUT,
            getenv('API_BASE_URI').self::API_BASE_PATH."/1",
            [
                'id'       => '1',
                'sku'      => 'INV001',
                'name'     => 'Producto 001 Editado',
                'type'     => 'kindle',
                'stock'    => '2998',
                'expireAt' => '2019-02-23T17:34:36+00:00',
            ]
        );
        $statusCode = $this->getClient()->getResponse()->getStatusCode();
        $content = json_decode($this->getClient()->getResponse()->getContent(), true);

        // Asserts for the PHPUnit tests.
        $this->assertArrayHasKey('status', $content);
        $this->assertEquals(200, $statusCode);
        $this->assertArrayHasKey('data', $content);
        if (!empty($content['data'])) {
            $this->assertArrayHasKey('id', $content['data']);
            $this->assertArrayHasKey('sku', $content['data']);
            $this->assertArrayHasKey('name', $content['data']);
            $this->assertArrayHasKey('type', $content['data']);
            $this->assertArrayHasKey('stock', $content['data']);
            $this->assertArrayHasKey('expireAt', $content['data']);
        }
    }

    /**
     * Test for Get single item from the inventory.
     */
    public function testRemoveAction()
    {
        // Sends the API request.
        $this->getClient()->request(
            HttpService::METHOD_DELETE,
            getenv('API_BASE_URI').self::API_BASE_PATH."/Producto 999",
            []
        );
        $statusCode = $this->getClient()->getResponse()->getStatusCode();
        $content = json_decode($this->getClient()->getResponse()->getContent(), true);

        // Asserts for the PHPUnit tests.
        $this->assertArrayHasKey('status', $content);
        $this->assertEquals(200, $statusCode);
        $this->assertArrayHasKey('data', $content);
        if (!empty($content['data'])) {
            $this->assertArrayHasKey('id', $content['data']);
            $this->assertArrayHasKey('sku', $content['data']);
            $this->assertArrayHasKey('name', $content['data']);
            $this->assertArrayHasKey('type', $content['data']);
            $this->assertArrayHasKey('stock', $content['data']);
            $this->assertArrayHasKey('expireAt', $content['data']);
        }
    }
}