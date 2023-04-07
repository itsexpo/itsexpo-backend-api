<?php

namespace App\Core\Domain\Models\Wahana3D\Member;

use App\Core\Domain\Models\NRP;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeamId;
use App\Core\Domain\Models\Wahana3D\Wahana3DMemberType;

class Wahana3DMember
{
    private Wahana3DMemberId $id;
    private ?Wahana3DTeamId $wahana_3d_team_id;
    private Wahana3DMemberType $member_type;
    private string $departemen_id;
    private string $name;
    private NRP $nrp;
    private string $kontak;
    private string $ktm_url;

    /**
     * @param Wahana3DMemberId $id
     * @param ?Wahana3DTeamId $wahana_3d_team_id
     * @param Wahana3DMemberType $member_type
     * @param string $name
     * @param NRP $nrp
     * @param string $kontak
     * @param string $ktm_url
     */
    public function __construct(Wahana3DMemberId $id, ?Wahana3DTeamId $wahana_3d_team_id, Wahana3DMemberType $member_type, string $departemen_id, string $name, NRP $nrp, string $kontak, string $ktm_url)
    {
        $this->id = $id;
        $this->wahana_3d_team_id = $wahana_3d_team_id;
        $this->member_type = $member_type;
        $this->departemen_id = $departemen_id;
        $this->name = $name;
        $this->nrp = $nrp;
        $this->kontak = $kontak;
        $this->ktm_url = $ktm_url;
    }

    /**
     * @throws Exception
     */
    public static function create(?Wahana3DTeamId $wahana_3d_team_id, Wahana3DMemberType $member_type, string $departemen_id, string $name, NRP $nrp, string $kontak, string $ktm_url): self
    {
        return new self(
            Wahana3DMemberId::generate(),
            $wahana_3d_team_id,
            $member_type,
            $departemen_id,
            $name,
            $nrp,
            $kontak,
            $ktm_url
        );
    }

    /**
     * @return Wahana3DMemberId
     */
    public function getId(): Wahana3DMemberId
    {
        return $this->id;
    }

    /**
     * @return ?Wahana3DTeamId
     */
    public function getTeamId(): ?Wahana3DTeamId
    {
        return $this->wahana_3d_team_id;
    }

    /**
     * @return Wahana3DMemberType
     */
    public function getMemberType(): Wahana3DMemberType
    {
        return $this->member_type;
    }

    /**
     * @return string
     */
    public function getDepartemenId(): string
    {
        return $this->departemen_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return NRP
     */
    public function getNrp(): NRP
    {
        return $this->nrp;
    }

    /**
     * @return string
     */
    public function getKontak(): string
    {
        return $this->kontak;
    }

    /**
     * @return string
     */
    public function getKtmUrl(): string
    {
        return $this->ktm_url;
    }
}
