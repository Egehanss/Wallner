<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacingTrait;

class Stonecutter extends Opaque
{
    use HorizontalFacingTrait;
    use FacesOppositePlacingPlayerTrait;

    public function readStateFromData(int $id, int $stateMeta) : void{
        $this->facing = BlockDataSerializer::readLegacyHorizontalFacing($stateMeta & 0x03);
    }

    protected function writeStateToMeta() : int{
        return BlockDataSerializer::writeLegacyHorizontalFacing($this->facing);
    }
    public function canBePlaced() : bool{
        return true;
    }
}