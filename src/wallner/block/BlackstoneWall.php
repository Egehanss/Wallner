<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class BlackstoneWall extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}