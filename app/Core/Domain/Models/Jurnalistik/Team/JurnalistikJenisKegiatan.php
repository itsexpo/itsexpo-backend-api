<?php

namespace App\Core\Domain\Models\Jurnalistik\Team;

enum JurnalistikJenisKegiatan : string
{
    case KHUSUS = 'khusus';
    case UMUM = 'umum';
}
