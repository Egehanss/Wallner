<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class BlackstoneDoubleSlab extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}