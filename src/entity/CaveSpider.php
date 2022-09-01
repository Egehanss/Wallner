<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\data\bedrock\EntityLegacyIds;

class CaveSpider extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::CAVE_SPIDER;
	const HEIGHT = 0.5;
}
