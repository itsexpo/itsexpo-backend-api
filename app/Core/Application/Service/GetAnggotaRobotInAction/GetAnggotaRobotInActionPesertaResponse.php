<?php

namespace App\Core\Application\Service\GetAnggotaRobotInAction;

use JsonSerializable;

class GetAnggotaRobotInActionPesertaResponse implements JsonSerializable
{
    private string $id;
    private string $name;
    private string $ketua;
    private string $share_poster;
    private string $id_card;
    private string $follow_sosmed;

    public function __construct(string $id, string $name, string $ketua, string $share_poster, string $id_card, string $follow_sosmed)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ketua = $ketua;
        $this->share_poster = $share_poster;
        $this->id_card = $id_card;
        $this->follow_sosmed = $follow_sosmed;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ketua' => $this->ketua,
            'share_poster' => $this->share_poster,
            'id_card' => $this->id_card,
            'follow_sosmed' => $this->follow_sosmed
        ];
    }
}
