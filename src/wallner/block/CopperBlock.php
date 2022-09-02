<?php

namespace pocketmine\wallner\block;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Opaque;

class CopperBlock extends Opaque
{

	public function __construct(BlockIdentifier $idInfo, ?BlockBreakInfo $breakInfo = null)
	{
		parent::__construct($idInfo, "Copper Block",$breakInfo ?? new BlockBreakInfo(0.9, BlockToolType::PICKAXE));
	}

	public function canBePlaced() : bool{
		return true;
	}
}