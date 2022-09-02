<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Planks as PMPlanks;

class Planks extends PMPlanks{

    public function burnsForever(): bool
    {
        return true;
    }

    public function getFuelTime(): int
    {
        return 0;
    }

    public function getFlammability(): int
    {
        return 0;
    }

    public function getFlameEncouragement(): int
    {
        return 0;
    }
}