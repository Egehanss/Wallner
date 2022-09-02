<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\math\Vector3;

class Bat extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::BAT;
	const HEIGHT = 0.9;

	public function initEntity(CompoundTag $nbt) : void{
      $this->setMaxHealth(4);
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
