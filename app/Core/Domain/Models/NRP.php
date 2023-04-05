<?php

namespace App\Core\Domain\Models;

class NRP
{
    private string $value;
    private string $kode_departemen;
    private string $angkatan;
    private string $semester_masuk;
    private string $nomor_reg;
    private string $departemen = ' ';
    private string $fakultas = ' ';

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->separate($value);
        // $this->validate($value, "22");
        $this->value = $value;
    }

    /**
     * @param string $kode_departemen
     * @param string $angkatan
     * @param string $semester_masuk
     * @param string $nomor_reg
     */
    public function separate(string $value)
    {
        $this->kode_departemen = substr($value, 0, 4);
        $this->angkatan = substr($value, 4, 2);
        $this->semester_masuk = substr($value, 6, 1);
        $this->nomor_reg = substr($value, 7, 3);

        switch ($this->kode_departemen) {
            case '5001':
                $this->departemen = "Fisika";
                $this->fakultas = "SCIENTICS";
                break;
            case '5002':
                $this->departemen = "Matematika";
                $this->fakultas = "SCIENTICS";
                break;
            case '5003':
                $this->departemen = "Statisika";
                $this->fakultas = "SCIENTICS";
                break;
            case '5004':
                $this->departemen = "Kimia";
                $this->fakultas = "SCIENTICS";
                break;
            case '5005':
                $this->departemen = "Biologi";
                $this->fakultas = "SCIENTICS";
                break;
            case '5006':
                $this->departemen = "Aktuaria";
                $this->fakultas = "SCIENTICS";
                break;
            case '5007':
                $this->departemen = "Teknik Mesin";
                $this->fakultas = "INDSYS";
                break;
            case '5008':
                $this->departemen = "Teknik Kimia";
                $this->fakultas = "INDSYS";
                break;
            case '5009':
                $this->departemen = "Teknik Fisika";
                $this->fakultas = "INDSYS";
                break;
            case '5010':
                $this->departemen = "Teknik Industri";
                $this->fakultas = "INDSYS";
                break;
            case '5011':
                $this->departemen = "Teknik Material";
                $this->fakultas = "INDSYS";
                break;
            case '5012':
                $this->departemen = "Teknik Sipil";
                $this->fakultas = "CIVPLAN";
                break;
            case '5013':
                $this->departemen = "Arsitektur";
                $this->fakultas = "CIVPLAN";
                break;
            case '5014':
                $this->departemen = "Teknik Lingkungan";
                $this->fakultas = "CIVPLAN";
                break;
            case '5015':
                $this->departemen = "PWK";
                $this->fakultas = "CIVPLAN";
                break;
            case '5016':
                $this->departemen = "Teknik Geomatika";
                $this->fakultas = "CIVPLAN";
                break;
            case '5017':
                $this->departemen = "Teknik Geofisika";
                $this->fakultas = "CIVPLAN";
                break;
            case '5018':
                $this->departemen = "Teknik Perkapalan";
                $this->fakultas = "MARTECH";
                break;
            case '5019':
                $this->departemen = "Teknik Sistem Perkapalan";
                $this->fakultas = "MARTECH";
                break;
            case '5020':
                $this->departemen = "Teknik Kelautan";
                $this->fakultas = "MARTECH";
                break;
            case '5021':
                $this->departemen = "Teknik Transportasi Laut";
                $this->fakultas = "MARTECH";
                break;
            case '5022':
                $this->departemen = "Teknik Elektro";
                $this->fakultas = "ELECTICS";
                break;
            case '5023':
                $this->departemen = "Teknik Biomedik";
                $this->fakultas = "ELECTICS";
                break;
            case '5024':
                $this->departemen = "Teknik Komputer";
                $this->fakultas = "ELECTICS";
                break;
            case '5025':
                $this->departemen = "Teknik Informatika";
                $this->fakultas = "ELECTICS";
                break;
            case '5026':
                $this->departemen = "Sistem Informasi";
                $this->fakultas = "ELECTICS";
                break;
            case '5027':
                $this->departemen = "Teknologi Informasi";
                $this->fakultas = "ELECTICS";
                break;
            case '5028':
                $this->departemen = "Desain Produk";
                $this->fakultas = "CREABIZ";
                break;
            case '5029':
                $this->departemen = "Desain Interior";
                $this->fakultas = "CREABIZ";
                break;
            case '5030':
                $this->departemen = "DKV";
                $this->fakultas = "CREABIZ";
                break;
            case '5031':
                $this->departemen = "Managemen Bisnis";
                $this->fakultas = "CREABIZ";
                break;
            case '5033':
                $this->departemen = "Studi Pembangunan";
                $this->fakultas = "CREABIZ";
                break;
            case '2038':
                $this->departemen = "Teknik Manufaktur";
                $this->fakultas = "VOCATIONS";
                break;
            case '2039':
                $this->departemen = "Teknik Konversi Energi";
                $this->fakultas = "VOCATIONS";
                break;
            case '2040':
                $this->departemen = "Teknik Otomasi";
                $this->fakultas = "VOCATIONS";
                break;
            case '2041':
                $this->departemen = "Teknik Kimia Industri";
                $this->fakultas = "VOCATIONS";
                break;
            case '2042':
                $this->departemen = "Teknik Instrumentasi";
                $this->fakultas = "VOCATIONS";
                break;
            case '2043':
                $this->departemen = "Statistika Bisnis";
                $this->fakultas = "VOCATIONS";
                break;
            default:
                $this->departemen = "";
                $this->fakultas = "";
                break;
        }
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getKodeDepartemen(): string
    {
        return $this->kode_departemen;
    }

    /**
     * @return string
     */
    public function getAngkatan(): string
    {
        return $this->angkatan;
    }

    /**
     * @return string
     */
    public function getSemesterMasuk(): string
    {
        return $this->semester_masuk;
    }

    /**
     * @return string
     */
    public function getNomorReg(): string
    {
        return $this->nomor_reg;
    }

    public function getDepartemen(): string
    {
        return $this->departemen;
    }

    public function getFakultas(): string
    {
        return $this->fakultas;
    }
}
