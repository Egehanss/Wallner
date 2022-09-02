<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class NetherWartBlock extends Opaque {

    public function isWarped() : bool {
        return false;
    }
}