<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Opaque;

class HoneyBlock extends Opaque
{
	public function canBePlaced() : bool{
		return true;
	}
}