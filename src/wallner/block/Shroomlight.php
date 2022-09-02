<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class Shroomlight extends Opaque {

    public function getLightLevel(): int
    {
        return 15;
    }

    public function isFlammable(): bool
    {
        return true;
    }
}