<?php

namespace App\Core\Application\Service\RegisterKTITeam;

use Illuminate\Http\UploadedFile;

class RegisterKTITeamRequest
{
    private string $team_name;
    private string $asal_instansi;
    private string $nama_ketua;
    private string $no_telp_ketua;
    private UploadedFile $follow_sosmed;
    private UploadedFile $repost_kti;
    private UploadedFile $twibbon;
    private UploadedFile $file_abstrak; // PDF

    /**
     * @param string $team_name
     * @param string $asal_instansi
     * @param string $nama_ketua
     * @param string $no_telp_ketua;
     * @param UploadedFile $follow_sosmed
     * @param UploadedFile $repost_kti
     * @param UploadedFile $twibbon
     * @param UploadedFile $file_abstrak
     */

    public function __construct(string $team_name, string $asal_instansi, string $nama_ketua, string $no_telp_ketua, UploadedFile $follow_sosmed, UploadedFile $repost_kti, UploadedFile $twibbon, UploadedFile $file_abstrak)
    {
        $this->team_name = $team_name;
        $this->asal_instansi = $asal_instansi;
        $this->nama_ketua = $nama_ketua;
        $this->no_telp_ketua = $no_telp_ketua;
        $this->follow_sosmed = $follow_sosmed;
        $this->repost_kti = $repost_kti;
        $this->twibbon = $twibbon;
        $this->file_abstrak = $file_abstrak;
    }

    /**
     * @return string
     */
     public function getTeamName(): string
     {
         return $this->team_name;
     }

     /**
      * @return string
      */
     public function getAsalInstansi(): string
     {
         return $this->asal_instansi;
     }

     /**
      * @return string
      */
     public function getNamaKetua(): string
     {
         return $this->nama_ketua;
     }

     /**
      * @return string
      */
     public function getNoTelpKetua(): string
     {
         return $this->no_telp_ketua;
     }

     /**
      * @return UploadedFile
      */
     public function getFollowSosmed(): UploadedFile
     {
         return $this->follow_sosmed;
     }

     /**
      * @return UploadedFile
      */
     public function getRepostKTI(): UploadedFile
     {
         return $this->repost_kti;
     }

     /**
      * @return UploadedFile
      */
     public function getTwibbon(): UploadedFile
     {
         return $this->twibbon;
     }

     /**
      * @return UploadedFile
      */
     public function getFileAbstrak(): UploadedFile
     {
         return $this->file_abstrak;
     }
}
