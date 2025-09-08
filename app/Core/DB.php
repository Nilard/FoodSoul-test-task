<?php

namespace App\Core;

use PDO;

class DB extends PDO
{
    /**
     * Construct the database.
     *
     * @throws \Exception
     *   If the database configuration is not set.
     */
    public function __construct()
    {
        $driver = getenv('DB_DRIVER');
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $database = getenv('DB_DATABASE');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        if (empty($driver) || empty($host) || empty($port) || empty($database) || empty($user) || empty($password)) {
            throw new \Exception('Database configuration is not set');
        }

        parent::__construct("{$driver}:host={$host};port={$port};dbname={$database}", $user, $password);
    }

    /**
     * Process the name of the table or column.
     *
     * @param string $name
     *   The name of the table or column to process.
     *
     * @return string
     *   The processed name of the table or column.
     */
    private function processName(string $name): string
    {
        $name = preg_replace('/[^A-Za-z0-9_]/', '', $name);
        return "`{$name}`";
    }

    /**
     * Prepare the fields for the SQL query.
     *
     * @param array $fields
     *   The fields to prepare.
     * @param bool $placeholders
     *   Whether to prepare the fields with placeholders.
     * @param string $delimiter
     *   The delimiter of the fields.
     *
     * @return string
     *   The prepared fields.
     */
    private function prepareFields(array $fields, bool $placeholders = false, string $delimiter = ','): string
    {
        $result = [];
        foreach ($fields as $field) {
            $field = $this->processName($field);
            if ($placeholders) {
                $field = "{$field} = ?";
            }
            $result[] = $field;
        }
        return implode($delimiter, $result);
    }

    /**
     * Create a table if it doesn't exist.
     *
     * @param string $tableName
     *   The name of the table to create.
     * @param array $data
     *   The data of the table to create.
     *
     * @return bool
     *   The result of the creation.
     */
    public function createTable(string $tableName, array $data): bool
    {
        $tableName = $this->processName($tableName);
        $fields = [];
        foreach ($data as $key => $value) {
            $key = $this->processName($key);
            $fields[] = "{$key} {$value}";
        }
        $fields = implode(',', $fields);

        $sql = "CREATE TABLE IF NOT EXISTS {$tableName} ({$fields})";
        return $this->exec($sql) !== false;
    }

    /**
     * Drop a table if it exists.
     *
     * @param string $tableName
     *   The name of the table to drop.
     *
     * @return bool
     *   The result of the dropping.
     */
    public function dropTable(string $tableName): bool
    {
        $tableName = $this->processName($tableName);

        $sql = "DROP TABLE IF EXISTS {$tableName}";
        return $this->exec($sql) !== false;
    }

    /**
     * Insert a record into a table.
     *
     * @param string $tableName
     *   The name of the table to insert.
     * @param array $data
     *   The data of the record to insert.
     *
     * @return bool
     *   The result of the inserting.
     */
    public function insert(string $tableName, array $data): bool
    {
        $tableName = $this->processName($tableName);
        $fields = $this->prepareFields(array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$tableName} ({$fields}) VALUES ({$placeholders})";
        $statement = $this->prepare($sql);
        return $statement->execute(array_values($data));
    }

    /**
     * Update a record in a table.
     *
     * @param string $tableName
     *   The name of the table to update.
     * @param array $data
     *   The data of the record to update.
     * @param array $where
     *   The where of the record to update.
     *
     * @return bool
     *   The result of the updating.
     */
    public function update(string $tableName, array $data, array $where): bool
    {
        $tableName = $this->processName($tableName);
        $fields = $this->prepareFields(array_keys($data), true);
        $fieldsWhere = $this->prepareFields(array_keys($where), true, ' AND ');

        $sql = "UPDATE {$tableName} SET {$fields} WHERE {$fieldsWhere}";
        $statement = $this->prepare($sql);
        return $statement->execute(array_merge(array_values($data), array_values($where)));
    }

    /**
     * Delete a record from a table.
     *
     * @param string $tableName
     *   The name of the table to delete.
     * @param array $data
     *   The data of the record to delete.
     *
     * @return bool
     *   The result of the deleting.
     */
    public function delete(string $tableName, array $data): bool
    {
        $tableName = $this->processName($tableName);
        $fields = $this->prepareFields(array_keys($data), true, ' AND ');

        $sql = "DELETE FROM {$tableName} WHERE {$fields}";
        $statement = $this->prepare($sql);
        return $statement->execute(array_values($data));
    }

    /**
     * Select a record from a table.
     *
     * @param string $tableName
     *   The name of the table to select.
     * @param array $data
     *   The data of the record to select.
     *
     * @return array
     *   The record of the selection.
     */
    public function select(string $tableName, array $data): array
    {
        $tableName = $this->processName($tableName);
        if (empty($data)) {
            $sql = "SELECT * FROM {$tableName}";
        } else {
            $fields = $this->prepareFields(array_keys($data), true, ' AND ');
            $sql = "SELECT * FROM {$tableName} WHERE {$fields}";
        }

        $statement = $this->prepare($sql);
        $statement->execute(empty($data) ? [] : array_values($data));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}
