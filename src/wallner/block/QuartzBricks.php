<?php

namespace pocketmine\wallner\block;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Opaque;
use pocketmine\block\utils\PillarRotationInMetadataTrait;

class QuartzBricks extends Opaque
{
    public function canBePlaced() : bool{
        return true;
    }
}