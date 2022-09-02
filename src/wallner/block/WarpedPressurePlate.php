<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class WarpedPressurePlate extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}