<?php

namespace App\Core\Domain\Models\ListEvent;

use Exception;

class ListEvent
{
    private int $id;
    private string $name;
    private int $kuota;
    private string $start_date;
    private string $close_date;

    /**
     * @param int $id
     * @param string $name
     * @param int $kuota
     * @param string $start_date
     * @param string $close_date
     */
    public function __construct(int $id, string $name, int $kuota, string $start_date, string $close_date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->kuota = $kuota;
        $this->start_date = $start_date;
        $this->close_date = $close_date;
    }

    /**
     * @throws Exception
     */
    public static function create(int $id, string $name, int $kuota, string $start_date, string $close_date): self
    {
        return new self(
            $id,
            $name,
            $kuota,
            $start_date,
            $close_date,
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

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->start_date;
    }

    /**
     * @return string
     */
    public function getCloseDate(): string
    {
        return $this->close_date;
    }
}
