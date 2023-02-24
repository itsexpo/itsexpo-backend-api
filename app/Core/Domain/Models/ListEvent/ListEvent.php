<?php

namespace App\Core\Domain\Models\ListEvent;

use Exception;
use Illuminate\Support\Facades\Date;

class ListEvent
{
    private int $id;
    private string $name;
    private int $kuota;
    private Date $start_date;
    private Date $close_date;

    /**
     * @param int $id
     * @param string $name
     * @param int $kuota
     * @param Date $start_date
     * @param Date $close_date
     */
    public function __construct(int $id, string $name, int $kuota, Date $start_date, Date $close_date)
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
    public static function create(int $id, string $name, int $kuota, Date $start_date, Date $close_date): self
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
     * @return Date
     */
    public function getStartDate(): Date
    {
        return $this->start_date;
    }

    /**
     * @return Date
     */
    public function getCloseDate(): Date
    {
        return $this->close_date;
    }
}
