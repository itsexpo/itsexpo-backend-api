<?php

namespace App\Core\Domain\Models\Jurnalistik\Team;

enum JenisKegiatan : string
{
    case KHUSUS = 'khusus';
    case UMUM = 'umum';
}
