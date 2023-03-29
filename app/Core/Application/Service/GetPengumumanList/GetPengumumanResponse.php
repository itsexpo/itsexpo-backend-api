<?php

namespace App\Core\Application\Service\GetPengumumanList;

use JsonSerializable;
use App\Core\Domain\Models\Pengumuman\Pengumuman;

class GetPengumumanResponse implements JsonSerializable
{
    private Pengumuman $pengumuman;

    /**
     * @param Pengumuman $pengumuman
     */
    public function __construct(Pengumuman $pengumuman)
    {
        $this->pengumuman = $pengumuman;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->pengumuman->getId()->toString(),
            'list_event_id' => $this->pengumuman->getListEventId(),
            'title' => $this->pengumuman->getTitle(),
            'description' => $this->pengumuman->getDescription(),
            'created_at' => $this->pengumuman->getCreatedAt(),
            'updated_at' => $this->pengumuman->getUpdatedAt(),
        ];
    }
}
