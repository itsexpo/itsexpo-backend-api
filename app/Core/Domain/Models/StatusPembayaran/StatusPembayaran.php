<?php

namespace App\Core\Domain\Models\StatusPembayaran;

use Exception;

class StatusPembayaran
{
    private int $id;
    private string $status;

    /**
     * @param int $id
     * @param string $status
     */
    public function __construct(int $id, string $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * @throws Exception
     */
    public static function create(int $id, string $status): self
    {
        return new self(
            $id,
            $status,
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
    public function getStatus(): string
    {
        return $this->status;
    }
}
