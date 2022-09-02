<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Torch;

class SoulTorch extends Torch {

    public function getLightLevel() : int{
        return 10;
    }
}
