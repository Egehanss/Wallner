<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Lantern;

class SoulLantern extends Lantern {

    public function getLightLevel(): int
    {
        return 10;
    }
}