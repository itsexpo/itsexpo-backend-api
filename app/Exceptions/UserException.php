<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UserException extends Exception
{
    private static int $status;
    private $data;

    public function __construct(string $message, int $code, int $status = 500, $data = null)
    {
        self::$status = $status;
        parent::__construct($message, $code);
        $this->data = $data;
    }

    /**
     * @throws Exception
     */
    public static function throw(string $message, int $code, int $status = 500, $data = [])
    {
        throw new self($message, $code, $status, $data);
    }

    public function render(): JsonResponse
    {
        if ($this->data) {
            return response()->json([
                "success" => false,
                "message" => $this->message,
                "code" => $this->code,
                "data" => $this->data
            ], self::$status);
        } else {
            return response()->json([
                "success" => false,
                "message" => $this->message,
                "code" => $this->code,
            ], self::$status);
        }
    }
}
