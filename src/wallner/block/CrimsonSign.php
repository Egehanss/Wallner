<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Transparent;

class CrimsonSign extends Transparent
{
    public function canBePlaced() : bool{
        return true;
    }
}