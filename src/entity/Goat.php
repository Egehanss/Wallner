<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\data\bedrock\EntityLegacyIds;

class Goat extends MobsEntity {

	const HEIGHT = 1.6;
	
	public static function getNetworkTypeId() : string
	{
        return "minecraft:goat";
	}
	

    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}



