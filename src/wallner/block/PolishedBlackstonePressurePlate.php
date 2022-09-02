<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class PolishedBlackstonePressurePlate extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}