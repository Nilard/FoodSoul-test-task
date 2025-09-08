<?php

namespace App\Models;

use App\App;
use App\Models\ModelInterface;

abstract class CommonModel extends App implements ModelInterface
{
    /**
     * The name of the model.
     *
     * @var string
     */
    protected string $modelName;

    /**
     * The fields of the model.
     *
     * @var array
     */
    protected array $fields;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $modelName, array $fields)
    {
        parent::__construct();
        $this->modelName = $modelName;
        $this->fields = ['id' => self::PRIMARY_KEY] + $fields;
        $this->createTable();
    }

    /**
     * {@inheritdoc}
     */
    public function createTable(): bool
    {
        return $this->db->createTable($this->modelName, $this->fields);
    }

    /**
     * {@inheritdoc}
     */
    public function dropTable(): bool
    {
        return $this->db->dropTable($this->modelName);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data): bool
    {
        return $this->db->insert($this->modelName, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $data): bool
    {
        return $this->db->update($this->modelName, $data, ['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): bool
    {
        return $this->db->delete($this->modelName, ['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $id): array
    {
        $result = $this->db->select($this->modelName, ['id' => $id]);
        return reset($result) ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(): array
    {
        return $this->db->select($this->modelName, []);
    }

    /**
     * {@inheritdoc}
     */
    public function getBy(array $data): array
    {
        return $this->db->select($this->modelName, $data);
    }
}
