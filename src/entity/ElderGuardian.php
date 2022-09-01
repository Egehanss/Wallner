<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\entity\Living;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\item\VanillaItems;
use pocketmine\data\bedrock\EntityLegacyIds;

class ElderGuardian extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::ELDER_GUARDIAN;
	const HEIGHT = 1.99;


    public function getDrops(): array{
        $lootingL = 1;
        $cause = $this->lastDamageCause;
        if($cause instanceof EntityDamageByEntityEvent){
            $dmg = $cause->getDamager();
            if($dmg instanceof Player){
              

                    $lootingL = 1;

            }
        }
        return [
            VanillaItems::PRISMARINE_CRYSTALS()->setCount(mt_rand(0, 1 * $lootingL)),
            VanillaItems::PRISMARINE_SHARD()->setCount(mt_rand(0, 2 * $lootingL)),
        ];
    }

    public function getXpDropAmount(): int
    {
        return 10;
    }
}
