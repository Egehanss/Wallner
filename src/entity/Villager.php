<?php

/*
 *  
 *  𝓕𝓾𝓻𝓴𝓪𝓷𝓨𝓴𝓼 tarafından baştan yazıldı
 *  
 *
 */

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataCollection;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataFlags;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\entity\MobsEntity;

class Villager extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::VILLAGER;
	const HEIGHT = 1.95;
}