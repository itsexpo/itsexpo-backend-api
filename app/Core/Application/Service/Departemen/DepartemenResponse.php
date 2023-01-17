<?php

namespace App\Core\Application\Service\Departemen;

use JsonSerializable;

class DepartemenResponse implements JsonSerializable
{
    private int $id;
    private string $name;

    /**
     * @param int $id
     * @param int $fakultas_id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
