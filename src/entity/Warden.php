<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\entity\Living;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use function mt_rand;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\item\VanillaItems;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\math\Vector3;

class Warden extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::WARDEN;
	const HEIGHT = 3;


    public function initEntity(CompoundTag $nbt) : void{
      $this->setMaxHealth(250);
     $this->setMovementSpeed(3.15);
     $this->attackdelay = 0;
        $this->defaultlook = new Vector3(0, 0, 0);
        $this->destination = new Vector3(0, 0, 0);
     $this->timer = -1;
        if ($this->isFlying() == true or $this->isSwimming() == true) {
        $this->setHasGravity(true);
        }
     parent::initEntity($nbt);
      
    }
	
  
    public function getDrops(): array{
        $lootingL = 1;
        $cause = $this->lastDamageCause;
        if($cause instanceof EntityDamageByEntityEvent){
            $dmg = $cause->getDamager();
            if($dmg instanceof Player){
              
                    $lootingL = 1;

            }
        }
        $drops = [
			
			VanillaItems::DIAMOND()->setCount(5 * $lootingL)
        ];

        return $drops;
    }

    public function getXpDropAmount(): int
    {
        return mt_rand(50, 70);
    }

}