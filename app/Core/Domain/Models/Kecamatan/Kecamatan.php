<?php

namespace App\Core\Domain\Models\Kecamatan;

class Kecamatan
{
    private int $id;
    private int $kabupaten_id;
    private string $name;

    /**
     * @param int $id
     * @param int $kabupaten_id
     * @param string $name
     */
    public function __construct(int $id, int $kabupaten_id, string $name)
    {
        $this->id = $id;
        $this->kabupaten_id = $kabupaten_id;
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
    public function getKabupatenId(): int
    {
        return $this->kabupaten_id;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
