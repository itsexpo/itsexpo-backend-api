<?php

namespace App\Core\Application\Service\AddPengumuman;

class AddPengumumanRequest
{
    private int $event_id;
    private string $title;
    private string $description;

    public function __construct(int $event_id, string $title, string $description)
    {
        $this->event_id = $event_id;
        $this->title = $title;
        $this->description = $description;
    }

    public function getListEventId(): int
    {
        return $this->event_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
