<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class Blackstone extends Opaque
{
    public function canBePlaced() : bool{
        return true;
    }
}