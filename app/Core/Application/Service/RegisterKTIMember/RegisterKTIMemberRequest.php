<?php

namespace App\Core\Application\Service\RegisterKTIMember;

use App\Core\Domain\Models\KTI\KTIMemberType;

class RegisterKTIMemberRequest
{
    private string $nama;
    private string $no_telp;
    private KTIMemberType $member_type;

    /**
     * @param string $nama
     * @param string $no_telp
     * @param string $member_type
     */
    public function __construct(string $nama, string $no_telp, KTIMemberType $member_type)
    {
        $this->nama = $nama;
        $this->no_telp = $no_telp;
        $this->member_type = $member_type;
    }

    /**
     * @return string
     */
    public function getNama(): string
    {
        return $this->nama;
    }

    /**
     * @return string
     */
    public function getNoTelp(): string
    {
        return $this->no_telp;
    }

    /**
     * @return KTIMemberType
     */
    public function getMemberType(): KTIMemberType
    {
        return $this->member_type;
    }
}
