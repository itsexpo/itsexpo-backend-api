<?php

namespace App\Core\Application\Service\Kecamatan;

class KecamatanRequest
{
    private string $kabupaten_id;

    /**
     * @param  mixed $id
     * @param  mixed $kabupaten_id
     * @param  mixed $name
     * @return void
     */
    public function __construct(string $kabupaten_id)
    {
        $this->kabupaten_id = $kabupaten_id;
    }

    /**
     * @return string
     */
    public function getKabupatenId(): string
    {
        return $this->kabupaten_id;
    }
}
