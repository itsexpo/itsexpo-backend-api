<?php

namespace App\Core\Application\Service\GetPengumumanList;

class GetPengumumanRequest
{
    private mixed $event_id;
    private mixed $pengumuman_id;
    private ?int $page;
    private ?int $per_page;

    public function __construct(int $event_id = null, ?string $pengumuman_id = null, ?int $page, ?int $per_page)
    {
        $this->event_id = $event_id;
        $this->pengumuman_id = $pengumuman_id;
        $this->page = $page;
        $this->per_page = $per_page;
    }


    public function getEventId(): int | null
    {
        return $this->event_id;
    }

    public function getPengumumanId(): string | null
    {
        return $this->pengumuman_id;
    }
    
    /**
     * @return ?int
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @return ?int
     */
    public function getPerPage(): ?int
    {
        return $this->per_page;
    }
}
