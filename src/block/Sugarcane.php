<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\VanillaBlocks;
use pocketmine\item\ItemFactory;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\event\block\BlockGrowEvent;
use pocketmine\item\Fertilizer;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\block\BlockLegacyIds as Ids;

class Sugarcane extends Flowable{

	protected int $age = 0;

	protected function writeStateToMeta() : int{
		return $this->age;
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->age = BlockDataSerializer::readBoundedInt("age", $stateMeta, 0, 15);
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

private function grow() : bool{
		$grew = false;
		for($y = 1; $y < 3; ++$y){
			if(!$this->position->getWorld()->isInWorld($this->position->x, $this->position->y + $y, $this->position->z)){
				break;
			}
			$b = $this->position->getWorld()->getBlockAt($this->position->x, $this->position->y + $y, $this->position->z);
			if($b->getId() === BlockLegacyIds::AIR){
				$ev = new BlockGrowEvent($b, VanillaBlocks::SUGARCANE());
				$ev->call();
				if($ev->isCancelled()){
					break;
				}
				            $worldn = $this->position->getWorld()->getFolderName();
				            $xx = $this->position->x;
							$yy = $this->position->y;
							$zz = $this->position->z;
							$worldfoldername = $worldn;
							$level = $this->position->getWorld();
							$positionblock = new Vector3((int) $this->position->x, (int) $this->position->y + 1, (int) $this->position->z);
						

							$kontrol = $this->blockkontrol($xx, $yy, $zz, $worldfoldername);
							if($kontrol === "buyut"){
				$this->position->getWorld()->setBlock($b->position, $ev->getNewState());
				$grew = true;
			}
			if($kontrol === "dropla" or $kontrol === "dropla2" or $kontrol === "dropla3" or $kontrol === "dropla4" or $kontrol === "dropla5"){
						 	$level->dropItem($positionblock, ItemFactory::getInstance()->get(338, 0, 1), new Vector3(0, 0, 0));
						 }
			}else{
				break;
			}
		}
		$this->age = 0;
		$this->position->getWorld()->setBlock($this->position, $this);
		return $grew;
	}

	public function getAge() : int{ return $this->age; }

	/** @return $this */
	public function setAge(int $age) : self{
		if($age < 0 || $age > 15){
			throw new \InvalidArgumentException("Age must be in range 0-15");
		}
		$this->age = $age;
		return $this;
	}
	 public function blockkontrol(int $xx, int $yy, int $zz, string $worldfoldername){

       	   $world = $this->position->getWorld()->getServer()->getWorldManager()->getWorldByName($worldfoldername);
       	   $level = $this->position->getWorld()->getServer()->getWorldManager()->getWorldByName($worldfoldername);
       	   $positionblock = new Vector3($xx, $yy, $zz);



 	            $blockyeni = $world->getBlockAt($xx, $yy + 1, $zz + 1); #en sağ
				$blockyeni2 = $world->getBlockAt($xx + 1, $yy + 1, $zz); #bi blok ileri
				$blockyeni3 = $world->getBlockAt($xx - 1, $yy + 1, $zz); #bi blok geri
				$blockyeni4 = $world->getBlockAt($xx, $yy + 1, $zz - 1); #en sol

				if($blockyeni->getId() == Ids::AIR){
				if($blockyeni2->getId() == Ids::AIR){
				if($blockyeni3->getId() == Ids::AIR){
				if($blockyeni4->getId() == Ids::AIR){
				$setb = $level->setBlock($positionblock, VanillaBlocks::SUGARCANE());
				return "buyut";

				

									}
								}
							}
						}




if($blockyeni->getId() == Ids::AIR){
	if($blockyeni2->getId() == Ids::AIR){
		if($blockyeni3->getId() == Ids::AIR){
			if(!$blockyeni4->getId() == Ids::AIR){
								return "dropla";
			}
		}
	}
}
if($blockyeni4->getId() == Ids::AIR){ 
	if($blockyeni2->getId() == Ids::AIR){
		if($blockyeni3->getId() == Ids::AIR){
			if(!$blockyeni->getId() == Ids::AIR){
				return "dropla2";
			}
		}
	}
}
if($blockyeni->getId() == Ids::AIR){ 
	if($blockyeni4->getId() == Ids::AIR){
		if($blockyeni3->getId() == Ids::AIR){
			if(!$blockyeni2->getId() == Ids::AIR){
								return "dropla3";
				}
			}
		}
	}
	if($blockyeni->getId() == Ids::AIR){
	if($blockyeni2->getId() == Ids::AIR){
		if($blockyeni4->getId() == Ids::AIR){
			if(!$blockyeni3->getId() == Ids::AIR){
								return "dropla4";
			}
		}
	}
}
if(!$blockyeni->getId() == Ids::AIR){
	if(!$blockyeni2->getId() == Ids::AIR){
		if(!$blockyeni4->getId() == Ids::AIR){
			if(!$blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
	if(!$blockyeni->getId() == Ids::AIR){
	if(!$blockyeni2->getId() == Ids::AIR){
		if(!$blockyeni4->getId() == Ids::AIR){
			if($blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
	if($blockyeni->getId() == Ids::AIR){
	if(!$blockyeni2->getId() == Ids::AIR){
		if(!$blockyeni4->getId() == Ids::AIR){
			if(!$blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
	if(!$blockyeni->getId() == Ids::AIR){
	if($blockyeni2->getId() == Ids::AIR){
		if(!$blockyeni4->getId() == Ids::AIR){
			if(!$blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
	if(!$blockyeni->getId() == Ids::AIR){
	if(!$blockyeni2->getId() == Ids::AIR){
		if($blockyeni4->getId() == Ids::AIR){
			if(!$blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
		if($blockyeni->getId() == Ids::AIR){
	if(!$blockyeni2->getId() == Ids::AIR){
		if($blockyeni4->getId() == Ids::AIR){
			if(!$blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
		if(!$blockyeni->getId() == Ids::AIR){
	if($blockyeni2->getId() == Ids::AIR){
		if(!$blockyeni4->getId() == Ids::AIR){
			if($blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
		if($blockyeni->getId() == Ids::AIR){
	if($blockyeni2->getId() == Ids::AIR){
		if(!$blockyeni4->getId() == Ids::AIR){
			if(!$blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
		if($blockyeni->getId() == Ids::AIR){
	if(!$blockyeni2->getId() == Ids::AIR){
		if(!$blockyeni4->getId() == Ids::AIR){ #1ve3 2ve4 4ve3 1ve4 2ve3 1ve2
			if($blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
		if($blockyeni->getId() == Ids::AIR){
	if(!$blockyeni2->getId() == Ids::AIR){
		if($blockyeni4->getId() == Ids::AIR){
			if($blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
			if(!$blockyeni->getId() == Ids::AIR){
	if($blockyeni2->getId() == Ids::AIR){
		if($blockyeni4->getId() == Ids::AIR){
			if(!$blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}
				if(!$blockyeni->getId() == Ids::AIR){
	if(!$blockyeni2->getId() == Ids::AIR){
		if($blockyeni4->getId() == Ids::AIR){
			if($blockyeni3->getId() == Ids::AIR){ 
								
				return "dropla5";
				}
			}
		}
	}



           }


	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($item instanceof Fertilizer){
			if(!$this->getSide(Facing::DOWN)->isSameType($this) && $this->grow()){
				$item->pop();
			}

			return true;
		}

		return false;
	}

	public function onNearbyBlockChange() : void{
		$down = $this->getSide(Facing::DOWN);
		if($down->isTransparent() and !$down->isSameType($this)){
			$this->position->getWorld()->useBreakOn($this->position);
		}
	}

	public function ticksRandomly() : bool{
		return true;
	}

	public function onRandomTick() : void{
		if(!$this->getSide(Facing::DOWN)->isSameType($this)){
			if($this->age === 15){
				$this->grow();
			}else{
				++$this->age;
				$this->position->getWorld()->setBlock($this->position, $this);
			}
		}
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		$down = $this->getSide(Facing::DOWN);
		if($down->isSameType($this)){
			return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
		}elseif($down->getId() === BlockLegacyIds::GRASS or $down->getId() === BlockLegacyIds::DIRT or $down->getId() === BlockLegacyIds::SAND or $down->getId() === BlockLegacyIds::PODZOL){
			foreach(Facing::HORIZONTAL as $side){
				if($down->getSide($side) instanceof Water){
					return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
				}
			}
		}

		return false;
	}
}