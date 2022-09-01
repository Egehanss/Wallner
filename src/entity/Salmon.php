<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\data\bedrock\EntityLegacyIds;

class Salmon extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::SALMON;
	const HEIGHT = 1.0;
	
}
