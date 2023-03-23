<?php

namespace App\Core\Application\Service\GetPengumumanList;

class GetPengumumanRequest
{
    private mixed $event_id;
    private mixed $pengumuman_id;

    public function __construct(int $event_id = null, ?string $pengumuman_id = null)
    {
        $this->event_id = $event_id;
        $this->pengumuman_id = $pengumuman_id;
    }


    public function getEventId(): int | null
    {
        return $this->event_id;
    }

    public function getPengumumanId(): string | null
    {
        return $this->pengumuman_id;
    }
}
