<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\entity\Living;
use function mt_rand;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Ocelot extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::OCELOT;
	const HEIGHT = 0.7;

   public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }

}
