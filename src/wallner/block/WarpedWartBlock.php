<?php

namespace pocketmine\wallner\block;

class WarpedWartBlock extends NetherWartBlock {

    public function isWarped(): bool
    {
        return true;
    }
}