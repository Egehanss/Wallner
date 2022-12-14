<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\entity\MobsEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\Living;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use function mt_rand;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\math\Vector3;

class Wolf extends MobsEntity {
	const TYPE_ID = EntityLegacyIds::WOLF;
	const HEIGHT = 0.85;

    public function getDrops(): array
    {
        $lootingL = 1;
        $cause = $this->lastDamageCause;
        if($cause instanceof EntityDamageByEntityEvent){
            $dmg = $cause->getDamager();
            if($dmg instanceof Player){
          
                    $lootingL = 1;
            }
        }
        return [ItemFactory::getInstance()->get(ItemIds::BONE, 0, mt_rand(0, 3 * $lootingL))];
    }

    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}
