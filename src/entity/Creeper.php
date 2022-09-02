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

class Creeper extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::CREEPER;
	const HEIGHT = 1.7;

    public function getDrops(): array
    {
        $lootingL = 1;
        $cause = $this->lastDamageCause;
        if($cause instanceof EntityDamageByEntityEvent){
            $dmg = $cause->getDamager();
            if($dmg instanceof Player){
              
                    $lootingL = 1;
            
        
        if (mt_rand(1, 10) < 3) {
            return [VanillaItems::GUNPOWDER()->setCount(1 * $lootingL)];
        }

        return [];
    }else{
return [];
        
    }
}
}

    public function getXpDropAmount(): int
    {
        $cause = $this->lastDamageCause;
        if($cause instanceof EntityDamageByEntityEvent){
            $dmg = $cause->getDamager();
            if($dmg instanceof Player){
        return 5 + mt_rand(1, 3);
    }else{
        return 0;
    }
}
    }

}
