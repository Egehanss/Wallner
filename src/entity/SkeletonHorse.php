<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\data\bedrock\EntityLegacyIds;

class SkeletonHorse extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::SKELETON_HORSE;
	const HEIGHT = 1.6;
}
