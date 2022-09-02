<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class ChiseledNetherBricks extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}