<?php

namespace App\Models;

interface SchemaInterface
{
    /**
     * The primary key of the table.
     */
    const PRIMARY_KEY = 'BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY';
    
    /**
     * The constructor of the schema.
     *
     * @param string $tableName
     *   The name of the table.
     * @param array $fields
     *   The fields of the table.
     */
    public function __construct(string $tableName, array $fields);

    /**
     * Create a table in the database.
     *
     * @return bool
     *   True if the table was created, false otherwise.
     */
    public function createTable(): bool;

    /**
     * Drop a table from the database.
     *
     * @return bool
     *   True if the table was dropped, false otherwise.
     */
    public function dropTable(): bool;
}
