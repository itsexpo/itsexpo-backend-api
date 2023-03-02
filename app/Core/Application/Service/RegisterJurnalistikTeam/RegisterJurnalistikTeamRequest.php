<?php

namespace App\Core\Application\Service\RegisterJurnalistikTeam;

class RegisterJurnalistikTeamRequest
{
    private string $team_name;
    private string $team_code;
    private string $lomba_category;
    private string $jenis_kegiatan;
    private int $jumlah_anggota;

    /**
     * @param string $team_name
     * @param string $team_code
     * @param string $lomba_category
     * @param string $jenis_kegiatan
     * @param int $jumlah_anggota
     */
    public function __construct(string $team_name, string $team_code, string $lomba_category, string $jenis_kegiatan, int $jumlah_anggota)
    {
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->lomba_category = $lomba_category;
        $this->jenis_kegiatan = $jenis_kegiatan;
        $this->jumlah_anggota = $jumlah_anggota;
    }

    /**
     * @return string
     */
    public function getTeamName() : string
    {
        return $this->team_name;
    }

    /**
     * @return string
     */
    public function getTeamCode() : string
    {
        return $this->team_code;
    }

    /**
     * @return string
     */
    public function getLombaCategory() : string
    {
        return $this->lomba_category;
    }

    /**
     * @return string
     */
    public function getJenisKegiatan() : string
    {
        return $this->jenis_kegiatan;
    }

    /**
     * @return int
     */
    public function getJumlahAnggota() : int
    {
        return $this->jumlah_anggota;
    }
}
