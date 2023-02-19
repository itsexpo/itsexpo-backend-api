<?php

namespace App\Core\Domain\Models\ListEvent;

use Exception;

class ListEvent
{
    private int $id;
    private string $name;
    private int $kuota;

    /**
     * @param int $id
     * @param string $name
     * @param int $kuota
     */
    public function __construct(int $id, string $name, int $kuota)
    {
        $this->id = $id;
        $this->name = $name;
        $this->kuota = $kuota;
    }

    /**
     * @throws Exception
     */
    public static function create(int $id, string $name, int $kuota): self
    {
        return new self(
            $id,
            $name,
            $kuota,
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getKuota(): int
    {
        return $this->kuota;
    }
}
