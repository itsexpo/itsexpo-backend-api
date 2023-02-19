<?php

namespace App\Core\Domain\Models\Pengumuman;

use Exception;

class Pengumuman
{
    private PengumumanId $id;
    private int $list_event_id;
    private string $title;
    private string $description;

    /**
     * @param PengumumanId $id
     * @param int $list_event_id
     * @param string $title
     * @param string $description
     */
    public function __construct(PengumumanId $id, int $list_event_id, string $title, string $description)
    {
        $this->id = $id;
        $this->list_event_id = $list_event_id;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @throws Exception
     */
    public static function create(int $list_event_id, string $title, string $description): self
    {
        return new self(
            PengumumanId::generate(),
            $list_event_id,
            $title,
            $description,
        );
    }

    /**
     * @return PengumumanId
     */
    public function getId(): PengumumanId
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getListEventId(): int
    {
        return $this->list_event_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
