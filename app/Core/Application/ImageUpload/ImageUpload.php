<?php

namespace App\Core\Application\ImageUpload;

use App\Exceptions\UserException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUpload
{
    private UploadedFile $uploaded_file;
    private array $available_type;
    private array $available_mime_type;
    private int $file_size_limit;
    private string $path;
    private string $seed;
    private string $name;
    private ?bool $is_large;

    public function __construct(UploadedFile $uploaded_file, string $path, string $seed, string $name, ?bool $is_large = false)
    {
        $this->uploaded_file = $uploaded_file;
        $this->path = $path;
        $this->seed = $seed;
        $this->name = trim($name);
        $this->is_large = $is_large;


        $this->available_type = [
            "jpg",
            "jpeg",
            "png",
            "pdf",
            "zip"
        ];

        $this->available_mime_type = [
            "image/jpg",
            "image/jpeg",
            "image/png",
            "application/pdf", // menambahkan MIME type PDF ke daftar MIME type yang diizinkan
            "application/zip" // menambahkan MIME type PDF ke daftar MIME type yang diizinkan
        ];
        $this->file_size_limit = 1048576;

        $this->check();
    }

    public static function create(UploadedFile $uploaded_file, string $path, string $seed, string $name, ?bool $is_large = false): self
    {
        return new self(
            $uploaded_file,
            $path,
            $seed,
            $name,
            $is_large
        );
    }

    /**
     * @throws UserException
     */
    public function check(): void
    {
        if (
            !in_array($this->uploaded_file->getClientOriginalExtension(), $this->available_type) ||
            !in_array($this->uploaded_file->getClientMimeType(), $this->available_mime_type)
        ) {
            UserException::throw("Tipe File {$this->name} Invalid", 2000);
        }
        if (!$this->is_large) {
            if ($this->uploaded_file->getSize() > 1048576) {
                UserException::throw("{$this->name} Harus Dibawah 1Mb", 2000);
            }
        } elseif ($this->uploaded_file->getSize() > 20971520) {
            UserException::throw("{$this->name} Harus Dibawah 20Mb", 2000);
        }
    }

    /**
     * @return string
     */
    public function upload(): string
    {
        $file_front = str_replace(" ", "_", strtolower($this->name));
        $encrypted_seed = base64_encode($this->seed);
        $uploaded = Storage::putFileAs(
            $this->path,
            $this->uploaded_file,
            $file_front."_".$encrypted_seed
        );
        if (!$uploaded) {
            UserException::throw("Upload {$this->name} Gagal", 2003);
        }
        $full_path = $this->path.'/'.$file_front."_".$encrypted_seed;
        return $full_path;
    }
}
