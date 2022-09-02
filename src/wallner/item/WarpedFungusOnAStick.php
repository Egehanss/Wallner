<?php

namespace pocketmine\wallner\item;

use pocketmine\item\Durable;

class WarpedFungusOnAStick extends Durable {

    public function getMaxDurability(): int
    {
        return 100;
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }

}