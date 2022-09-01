<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;

use pocketmine\data\bedrock\EntityLegacyIds;

class Blaze extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::BLAZE;
	const HEIGHT = 1.8;
}
