<?php

namespace App\Models;

interface ModelInterface extends SchemaInterface
{
    /**
     * The constructor of the model.
     *
     * @param string $modelName
     *   The name of the model.
     * @param array $fields
     *   The fields of the model.
     */
    public function __construct(string $modelName, array $fields);

    /**
     * Create a new record in the database.
     *
     * @param array $data
     *   The data of the record.
     *
     * @return bool
     *   True if the record was created, false otherwise.
     */
    public function create(array $data): bool;

    /**
     * Update a model in the database.
     *
     * @param int $id
     *   The id of the model.
     * @param array $data
     *   The data of the model.
     *
     * @return bool
     *   True if the model was updated, false otherwise.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a model from the database.
     *
     * @param int $id
     *   The id of the record.
     *
     * @return bool
     *   True if the record was deleted, false otherwise.
     */
    public function delete(int $id): bool;

    /**
     * Get a model from the database.
     *
     * @param int $id
     *   The id of the model.
     *
     * @return array
     *   The record of the model.
     */
    public function get(int $id): array;

    /**
     * Get all models from the database.
     *
     * @return array
     *   The records of the models.
     */
    public function getAll(): array;

    /**
     * Get a record from the database by a given condition.
     *
     * @param array $data
     *   The data of the record.
     *
     * @return array
     *   The record of the model by the given condition.
     */
    public function getBy(array $data): array;
}
