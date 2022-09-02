<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class HoneyCombBlock extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}