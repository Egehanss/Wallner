<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class SoulSoil extends Opaque {

    public function burnsForever(): bool
    {
        return true;
    }
}