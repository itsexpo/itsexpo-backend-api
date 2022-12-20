<?php

namespace App\Core\Domain\Models\Desa;

class Desa
{
    private int $id;
    private int $kecamatan_id;
    private string $name;

    /**
     * @param int $id
     * @param int $kecamatan_id
     * @param string $name
     */
    public function __construct(int $id, int $kecamatan_id, string $name)
    {
        $this->id = $id;
        $this->kecamatan_id = $kecamatan_id;
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
    public function getKecamatanId(): int
    {
        return $this->kecamatan_id;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
