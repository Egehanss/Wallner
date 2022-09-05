<?php


declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\data\bedrock\LegacyEntityIdToStringIdMap;
use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Living;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\mobs\Attributes;
use pocketmine\entity\mobs\Motion;

class MobsEntity extends Living {
	
	const TYPE_ID = 0;
	const HEIGHT = 0.0;

	public $attackdelay;
	public $defaultlook;
	public $destination;
	public $timer;

	public static function getNetworkTypeId() : string {
		return LegacyEntityIdToStringIdMap::getInstance()->legacyToString(static::TYPE_ID);
	}

	public function initEntity(CompoundTag $nbt) : void {
		$this->setImmobile(false);
		$this->setHasGravity(true);

		$this->attackdelay = 0;
		$this->defaultlook = new Vector3(0, 0, 0);
		$this->destination = new Vector3(0, 0, 0);
		$this->timer = -1;
		if ($this->isFlying() == true or $this->isSwimming() == true) {
		$this->setHasGravity(false);
		}

		parent::initEntity($nbt);
}

	public function getName() : string {
		$data = explode("\\", get_class($this));
		$name = end($data);
		return $name;
	}

	protected function getInitialSizeInfo() : EntitySizeInfo {
		return new EntitySizeInfo(1.8, 0.6);
	}

	public function canSaveWithChunk() : bool {
		return false;
	}

	public function setDefaultLook(Vector3 $defaultlook) {
		$this->defaultlook = $defaultlook;
	}

	public function getDefaultLook() {
		return $this->defaultlook;
	}

	public function setDestination(Vector3 $destination) {
		$this->destination = $destination;
	}

	public function getDestination() : Vector3 {
		return $this->destination;
	}

	public function setTimer(int $timer) {
		$this->timer = $timer;
	}

	public function getTimer() : int {
		return $this->timer;
	}

	public function setAttackDelay(int $attackdelay) {
		$this->attackdelay = $attackdelay;
	}

	public function getAttackDelay() {
		return $this->attackdelay;
	}

	public function knockBack(float $x, float $z, float $force = 0.4, ?float $verticalLimit = 0.4): void {
		if ($this->AggressiveCreatures() == true) {
			$this->timer = 20;
			$this->setMovementSpeed(1.50);
		} else {
			$this->timer = 10;
			$this->setMovementSpeed(2.20);
		}

		parent::knockBack($x, $z, $force);
	}

	public function entityBaseTick(int $diff = 1) : bool {
		(new Motion)->tick($this);
		return parent::entityBaseTick($diff);
	}
	public function mortalEnemy() : string {
		return (new Attributes)->getEnemyAttack($this->getName());
	}
	public function canBeCaughtinSunLight() : bool {
		return (new Attributes)->canBeCaughtinSunLight($this->getName());
	}
	public function isFlying() : bool {
		return (new Attributes)->isFlying($this->getName());
	}
	public function isJumping() : bool {
		return (new Attributes)->isJumping($this->getName());
	}
	public function AggressiveCreatures() : bool {
		return (new Attributes)->AggressiveCreatures($this->getName());
	}
	public function isSnowMonster() : bool {
		return (new Attributes)->isSnowMonster($this->getName());
	}
	public function isCreeper() : bool {
		return (new Attributes)->isCreeper($this->getName());
	}
	public function isSkeleton() : bool {
		return (new Attributes)->isSkeleton($this->getName());
	}
	public function isSwimming() : bool {
		$swim = (new Attributes)->isSwimming($this->getName());
		$ticks = $this->getAirSupplyTicks();
		$maxticks = $this->getMaxAirSupplyTicks();
		if ($swim == true and $this->isBreathing() == false and $ticks < ($maxticks/2)) {
			$this->setAirSupplyTicks($maxticks);
		}
		return $swim;
	}

	public function fall(float $fallDistance) : void {
	}
}