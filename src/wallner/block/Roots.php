<?php

namespace pocketmine\wallner\block;

use pocketmine\block\Block;
use pocketmine\block\Flowable;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Roots extends Flowable {

    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool
    {
        if(!$this->getSide(Facing::DOWN)->isSolid()){
            return false;
        }
        return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
    }

    public function onNearbyBlockChange(): void
    {
        if(!$this->getSide(Facing::DOWN)->isSolid()){
            $this->position->getWorld()->useBreakOn($this->position);
        }
    }
}