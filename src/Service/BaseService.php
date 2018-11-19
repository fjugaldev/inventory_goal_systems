<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Request;

/**
 * Interface BaseService
 */
interface BaseService
{
    /**
     * @param int $id
     *
     * @return array
     */
    public function get(int $id): array;

    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param \stdClass $parameters
     *
     * @return array
     */
    public function add(\stdClass $parameters): array;

    /**
     * @param int       $id
     * @param \stdClass $parameters
     *
     * @return array
     */
    public function edit(int $id, \stdClass $parameters): array;

    /**
     * @param string $name
     *
     * @return array
     */
    public function remove(string $name): array;
}