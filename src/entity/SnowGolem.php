<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\entity\Living;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataCollection;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use function mt_rand;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\item\VanillaItems;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\math\Vector3;
use pocketmine\block\VanillaBlocks;

class SnowGolem extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::SNOW_GOLEM;
	const HEIGHT = 1.0;

	public function initEntity(CompoundTag $nbt) : void{
      $this->setMaxHealth(10);
	 $this->setMovementSpeed(1.15);
	 $this->attackdelay = 0;
		$this->defaultlook = new Vector3(0, 0, 0);
		$this->destination = new Vector3(0, 0, 0);
	 $this->timer = -1;
	 	if ($this->isFlying() == true or $this->isSwimming() == true) {
		$this->setHasGravity(true);
		}
	 parent::initEntity($nbt);
      
    }
}