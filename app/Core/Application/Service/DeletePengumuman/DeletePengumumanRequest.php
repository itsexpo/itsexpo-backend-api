<?php

namespace App\Core\Application\Service\DeletePengumuman;

class DeletePengumumanRequest
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getPengumumanId()
    {
        return $this->id;
    }
}
