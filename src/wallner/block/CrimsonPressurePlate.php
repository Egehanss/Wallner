<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class CrimsonPressurePlate extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}