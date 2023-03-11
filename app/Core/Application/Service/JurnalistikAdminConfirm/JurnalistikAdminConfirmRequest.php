<?php

namespace app\Core\Application\Service\JurnalistikAdminConfirm;

class JurnalistikAdminConfirmRequest
{
    private string $id;
    private int $status;

    /**
     * @param string $id
     * @param int $status
     */
    public function __construct(string $id, int $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
