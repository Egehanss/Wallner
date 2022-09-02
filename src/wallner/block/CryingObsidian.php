<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class CryingObsidian extends Opaque
{
    public function canBePlaced() : bool
    {
        return true;
    }
    public function getLightLevel(): int
    {
        return 10;
    }
}