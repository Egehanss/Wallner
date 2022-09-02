<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;

use pocketmine\entity\Living;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use function mt_rand;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\math\Vector3;
use pocketmine\block\VanillaBlocks;

class Skeleton extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::SKELETON;
	const HEIGHT = 1.99;


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


    public function getDrops(): array{
        $lootingL = 1;
        $cause = $this->lastDamageCause;
        if($cause instanceof EntityDamageByEntityEvent){
            $dmg = $cause->getDamager();
            if($dmg instanceof Player){
              
                // $looting = $dmg->getInventory()->getItemInHand()->getEnchantment(Enchantment::LOOTING);
                // if($looting !== null){
                    // $lootingL = $looting->getLevel();
                // }else{
                    $lootingL = 1;
            // }
            }
        }
        return [
            ItemFactory::getInstance()->get(ItemIds::ARROW, 0, mt_rand(0, 2 * $lootingL)),
            ItemFactory::getInstance()->get(ItemIds::BONE, 0, mt_rand(0, 2 * $lootingL)),
        ];
    }

    public function getXpDropAmount(): int
    {
        return 5 + mt_rand(1, 3);
    }
}
