<?php

namespace App\Core\Application\Service\UpdatePengumuman;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePengumumanRequest extends FormRequest
{
    private int $event_id;
    private string $title;
    private string $description;
    private string $id;

    public function __construct(int $event_id, string $title, string $description, string $id)
    {
        $this->event_id = $event_id;
        $this->title = $title;
        $this->description = $description;
        $this->id = $id;
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

    public function getPengumumanId(): string
    {
        return $this->id;
    }
}
