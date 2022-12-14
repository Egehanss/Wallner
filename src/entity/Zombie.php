<?php

/*
 *  
 *  𝓕𝓾𝓻𝓴𝓪𝓷𝓨𝓴𝓼 tarafından baştan yazıldı
 *  
 *
 */

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use pocketmine\item\ItemIds;
use pocketmine\entity\MobsEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\math\Vector3;
use function mt_rand;

class Zombie extends MobsEntity {
    const TYPE_ID = EntityLegacyIds::ZOMBIE;
    const HEIGHT = 1.95;


    public function getDrops(): array
    {
        $lootingL = 1;
        $cause = $this->lastDamageCause;
        if ($cause instanceof EntityDamageByEntityEvent) {
            $dmg = $cause->getDamager();
            if ($dmg instanceof Player) {


                    $lootingL = 1;

            }
        }
        $drops = [
            ItemFactory::getInstance()->get(ItemIds::ROTTEN_FLESH, 0, mt_rand(0, 2 * $lootingL))
        ];

        if (mt_rand(0, 199) < 5) {
            switch (mt_rand(0, 2)) {
                case 0:
                    $drops[] = ItemFactory::getInstance()->get(ItemIds::IRON_INGOT, 0, 1 * $lootingL);
                    break;
                case 1:
                    $drops[] = ItemFactory::getInstance()->get(ItemIds::CARROT, 0, 1 * $lootingL);
                    break;
                case 2:
                    $drops[] = ItemFactory::getInstance()->get(ItemIds::POTATO, 0, 1 * $lootingL);
                    break;
            }
        }

        return $drops;
    }

    public function getXpDropAmount(): int
    {
        return 5 + mt_rand(1, 3);
    }
}