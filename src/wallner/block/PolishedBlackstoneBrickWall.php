<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class PolishedBlackstoneBrickWall extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}