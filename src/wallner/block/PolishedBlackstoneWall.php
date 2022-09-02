<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class PolishedBlackstoneWall extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}