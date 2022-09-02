<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\entity\Living;
use pocketmine\player\Player;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\math\Vector3;

class Bee extends MobsEntity
{

	public function initEntity(CompoundTag $nbt) : void{
      $this->setMaxHealth(6);
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

	protected function getInitialSizeInfo() : EntitySizeInfo
	{
		return new EntitySizeInfo(0.6, 0.6);
	}
	
	public static function getNetworkTypeId() : string
	{
		return EntityIds::BEE;
	}
	

    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}