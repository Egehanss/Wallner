<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Transparent;

class Target extends Transparent {

    public function isFlammable(): bool
    {
        return true;
    }

}