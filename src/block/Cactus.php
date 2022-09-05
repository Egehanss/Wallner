<?php


declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockGrowEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\block\BlockLegacyIds as Ids;
use pocketmine\block\VanillaBlocks;

class Cactus extends Transparent{

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function hasEntityCollision() : bool{
		return true;
	}

	protected function recalculateCollisionBoxes() : array{
		$shrinkSize = 1 / 16;
		return [AxisAlignedBB::one()->contract($shrinkSize, 0, $shrinkSize)->trim(Facing::UP, $shrinkSize)];
	}

	public function onEntityInside(Entity $entity) : bool{
		$ev = new EntityDamageByBlockEvent($this, $entity, EntityDamageEvent::CAUSE_CONTACT, 1); #kaktüs hasarı
		$entity->attack($ev);
		return true;
	}

	public function onNearbyBlockChange() : void{
		$down = $this->getSide(Facing::DOWN);
		if($down->getId() !== BlockLegacyIds::SAND and !$down->isSameType($this)){
			$this->position->getWorld()->useBreakOn($this->position);
		}else{
			foreach(Facing::HORIZONTAL as $side){
				$b = $this->getSide($side);
				if($b->isSolid()){
					$this->position->getWorld()->useBreakOn($this->position);
					break;
				}
			}
		}
	}


	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		$kontrol = $this->kontrollimit();
		if($kontrol === "uygun"){
        $this->orankontrol();
		}
	}
	public function orankontrol(){
	$sans = $this->position->getWorld()->getServer()->getWallnerIntConfig("kaktus-buyume-sansi");
    $oran = rand(1, $sans);
    switch($oran){
    	case 1:
     $this->kaktusubuyut();
    	break;
    }
	}
    public function kaktusubuyut(){
    $world = $this->position->getWorld();
    $positionblock = new Vector3($this->position->x, $this->position->y + 1, $this->position->z);
    if($world->isInWorld((int) $this->position->x, (int) $this->position->y + 1, (int) $this->position->z)){
    $world->setBlock($positionblock, VanillaBlocks::CACTUS());
    }
}
	public function kontrollimit(){
		$world = $this->position->getWorld();
		$worldname = $this->position->getWorld()->getFolderName();
		$positionblock = new Vector3($this->position->x, $this->position->y, $this->position->z);

 	    $block1 = $world->getBlockAt($this->position->x, $this->position->y, $this->position->z); #bloğun konumu
 	    $block2 = $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z); #bloğun bir üstü
 	    $block3 = $world->getBlockAt($this->position->x, $this->position->y + 2, $this->position->z); #bloğun iki üstü
 	    $block4 = $world->getBlockAt($this->position->x, $this->position->y - 1, $this->position->z); #bloğun bir altı
 	    $block5 = $world->getBlockAt($this->position->x, $this->position->y - 2, $this->position->z); #bloğun iki altı

 	    
 	if($block1->getId() == Ids::CACTUS){
 	    	if($block2->getId() == Ids::AIR){
 	    			if($block4->getId() == Ids::SAND){
 	    				return "uygun";
 	    		}

 	    }
 	}
 	    			if($block5->getId() == Ids::SAND){
 	    				if($block4->getId() == Ids::CACTUS){
 	    					if($block2->getId() == Ids::AIR){
 	    				return "uygun";
 	    		}
 	    	}
 	    	}

	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{

		$down = $this->getSide(Facing::DOWN);
		if($down->getId() === BlockLegacyIds::SAND or $down->isSameType($this)){
			foreach(Facing::HORIZONTAL as $side){
				if($this->getSide($side)->isSolid()){
					return false;
				}
			}

			return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		}

		return false;
	}
}