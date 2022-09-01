<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\entity\Living;
use pocketmine\event\entity\{
    EntityDamageByEntityEvent, EntityDamageEvent
};
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataCollection;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\nbt\tag\{
    IntTag
};
use pocketmine\player\Player;
use function mt_rand;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\item\VanillaItems;
use pocketmine\data\bedrock\EntityLegacyIds;

class Rabbit extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::RABBIT;
	const HEIGHT = 0.5;
	



    

}
