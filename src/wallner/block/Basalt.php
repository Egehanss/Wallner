<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;
use pocketmine\block\utils\PillarRotationInMetadataTrait;

class Basalt extends Opaque {

    use PillarRotationInMetadataTrait;

    protected function getAxisMetaShift() : int{
        return 0;
    }
    public function canBePlaced(): bool
    {
        return true;
    }
}