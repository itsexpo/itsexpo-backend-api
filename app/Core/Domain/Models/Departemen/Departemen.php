<?php

namespace App\Core\Domain\Models\Departemen;

class Departemen
{
    private int $id;
    private int $fakultas_id;
    private string $name;

    /**
     * @param int $id
     * @param int $fakultas_id
     * @param string $name
     */
    public function __construct(int $id, int $fakultas_id, string $name)
    {
        $this->id = $id;
        $this->fakultas_id = $fakultas_id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getFakultasId(): int
    {
        return $this->fakultas_id;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
