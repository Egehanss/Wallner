<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;

use pocketmine\data\bedrock\EntityLegacyIds;

class Ghast extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::GHAST;
	const HEIGHT = 4.0;
}
