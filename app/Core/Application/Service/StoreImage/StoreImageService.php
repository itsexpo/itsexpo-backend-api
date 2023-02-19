<?php

namespace App\Core\Application\Service\StoreImage;

use Exception;
use Illuminate\Support\Str;
use App\Exceptions\UserException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreImageService
{
    /**
     * @throws Exception
     */
    public function execute(UploadedFile $file_test)
    {
        if ($file_test->getSize() > 1048576) {
            UserException::throw("bukti bayar harus dibawah 1Mb", 2043);
        }

        $path = Storage::putFileAs('Testing', $file_test, Str::random(16));
        if (!$path) {
            UserException::throw("Gagal Menyimpan File", 6005);
        }

        return [
            "path" => $path
        ];
    }
}
