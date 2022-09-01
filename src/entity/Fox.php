<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;

use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\entity\Living;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use function mt_rand;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Fox extends MobsEntity {

	const HEIGHT = 1.6;
	
	public static function getNetworkTypeId() : string
	{
		return EntityIds::FOX;
	}


    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}
