<?php

namespace App\Models;

use App\Models\CommonModel;

class Entity extends CommonModel
{
    /**
     * The name of the entity.
     *
     * @var string
     */
    protected string $entityName;

    /**
     * The constructor of the entity.
     *
     * @param string $entityName
     *   The name of the entity.
     * @param array $fields
     *   The fields of the entity.
     */
    public function __construct(string $entityName, array $fields)
    {
        $this->entityName = $entityName;
        $this->modelName = $entityName;

        parent::__construct($entityName, $fields);
    }
}
