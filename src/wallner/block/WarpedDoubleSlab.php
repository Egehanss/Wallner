<?php

namespace pocketmine\wallner\block;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Opaque;

class WarpedDoubleSlab extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}