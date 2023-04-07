<?php

namespace App\Core\Application\Service\GetUserWahanaSeni;

use JsonSerializable;

class GetUserWahanaSeniResponse implements JsonSerializable
{
    private ?GetUserWahana2DResponse $wahana2d;
    private ?GetUserWahana3DResponse $wahana3d;

    public function __construct(GetUserWahana2DResponse $wahana2d = null, GetUserWahana3DResponse $wahana3d = null)
    {
        $this->wahana2d = $wahana2d;
        $this->wahana3d = $wahana3d;
    }

    public function jsonSerialize()
    {
        return [
            "main_event" => [
                "wahana_seni" => [
                    "2d" => $this->wahana2d,
                    "3d" => $this->wahana3d
                ]
            ]
        ];
    }
}
