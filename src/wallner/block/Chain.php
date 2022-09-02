<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Transparent;
use pocketmine\block\utils\PillarRotationInMetadataTrait;

class Chain extends Transparent
{
    use PillarRotationInMetadataTrait;

    protected function getAxisMetaShift(): int
    {
        return 0;
    }

    public function canBePlaced(): bool
    {
        return true;
    }
}

