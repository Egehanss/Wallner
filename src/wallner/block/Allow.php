<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class Allow extends Opaque
{
    public function canBePlaced() : bool{
        return true;
    }
}