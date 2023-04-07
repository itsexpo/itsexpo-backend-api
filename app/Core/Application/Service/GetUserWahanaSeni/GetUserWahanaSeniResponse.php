<?php

namespace App\Core\Application\Service\GetUserWahanaSeni;

use JsonSerializable;

class GetUserWahanaSeniResponse implements JsonSerializable
{
    private ?GetUserWahana2DResponse $wahana2d;

    public function __construct(?GetUserWahana2DResponse $wahana2d)
    {
        $this->wahana2d = $wahana2d;
    }

    public function jsonSerialize()
    {
        return [
            "main_event" => [
                "wahana_seni" => [
                    "2d" => $this->wahana2d
                ]
            ]
        ];
    }
}
