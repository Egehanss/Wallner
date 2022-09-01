<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;

use pocketmine\data\bedrock\EntityLegacyIds;

class Silverfish extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::SILVERFISH;
	const HEIGHT = 0.3;
}
