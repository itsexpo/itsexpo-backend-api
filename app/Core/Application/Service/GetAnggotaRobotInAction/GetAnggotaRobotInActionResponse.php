<?php

namespace App\Core\Application\Service\GetAnggotaRobotInAction;

use JsonSerializable;

class GetAnggotaRobotInActionResponse implements JsonSerializable
{
    private string $id_tim;
    private string $name_tim;
    private bool $is_ketua;
    private string $code_tim;
    private string $desripsi_karya;
    private ?string $payment_id;
    private string $payment_status;
    private array $peserta;
    private string $personal_id;
    private string $personal_name;
    private string $personal_follow_sosmed;
    private string $personal_id_card;
    private string $personal_share_poster;
    private string $personal_asal_instansi;

    public function __construct(
        string $id_tim,
        string $name_tim,
        bool $is_ketua,
        string $code_tim,
        string $desripsi_karya,
        ?string $payment_id,
        string $payment_status,
        array $peserta,
        string $personal_id,
        string $personal_name,
        string $personal_follow_sosmed,
        string $personal_id_card,
        string $personal_share_poster,
        string $personal_asal_instansi
    ) {
        $this->id_tim = $id_tim;
        $this->name_tim = $name_tim;
        $this->is_ketua = $is_ketua;
        $this->code_tim = $code_tim;
        $this->desripsi_karya = $desripsi_karya;
        $this->payment_id = $payment_id;
        $this->payment_status = $payment_status;
        $this->peserta = $peserta;
        $this->personal_id = $personal_id;
        $this->personal_name = $personal_name;
        $this->personal_follow_sosmed = $personal_follow_sosmed;
        $this->personal_id_card = $personal_id_card;
        $this->personal_share_poster = $personal_share_poster;
        $this->personal_asal_instansi = $personal_asal_instansi;
    }

    public function jsonSerialize(): array
    {
        return [
            'id_tim' => $this->id_tim,
            'name_tim' => $this->name_tim,
            'ketua_tim' => $this->is_ketua,
            'code_tim' => $this->code_tim,
            'deskripsi_karya' => $this->desripsi_karya,
            'payment' => [
                'id' => $this->payment_id,
                'status' => $this->payment_status
            ],
            'peserta' => $this->peserta,
            'personal' => [
                'id' => $this->personal_id,
                'name' => $this->personal_name,
                'follow_sosmed' => $this->personal_follow_sosmed,
                'id_card' => $this->personal_id_card,
                'share_poster' => $this->personal_share_poster,
                'asal_instansi' => $this->personal_asal_instansi,
            ],
        ];
    }
}
