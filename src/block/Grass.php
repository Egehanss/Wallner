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

use pocketmine\entity\Zombie;
use pocketmine\entity\ZombieVillager;
use pocketmine\entity\Wolf;
use pocketmine\entity\Witch;
use pocketmine\entity\Vindicator;
use pocketmine\entity\TropicalFish;
use pocketmine\entity\Stray;
use pocketmine\entity\Spider;
use pocketmine\entity\Slime;
use pocketmine\entity\SkeletonHorse;
use pocketmine\entity\Skeleton;
use pocketmine\entity\Silverfish;
use pocketmine\entity\Salmon;
use pocketmine\entity\Rabbit;
#use pocketmine\entity\PufferFish;
use pocketmine\entity\PolarBear;
use pocketmine\entity\Pig;
use pocketmine\entity\Phantom;
use pocketmine\entity\Parrot;
use pocketmine\entity\Ocelot;
use pocketmine\entity\Mooshroom;
use pocketmine\entity\MagmaCube;
use pocketmine\entity\IronGolem;
use pocketmine\entity\Llama;
use pocketmine\entity\Husk;
use pocketmine\entity\Horse;
use pocketmine\entity\Guardian;
use pocketmine\entity\Goat;
use pocketmine\entity\Ghast;
use pocketmine\entity\Fox;
use pocketmine\entity\Evoker;
use pocketmine\entity\Enderman;
use pocketmine\entity\ElderGuardian;
use pocketmine\entity\Drowned;
use pocketmine\entity\Donkey;
use pocketmine\entity\Dolphin;
use pocketmine\entity\Creeper;
use pocketmine\entity\Cow;
use pocketmine\entity\Cod;
use pocketmine\entity\Chicken;
use pocketmine\entity\CaveSpider;
use pocketmine\entity\Cat;
use pocketmine\entity\Blaze;
use pocketmine\entity\Bee;
use pocketmine\entity\Bat;
use pocketmine\entity\Axolotl;
use pocketmine\entity\Sheep;
use pocketmine\entity\Squid;
use pocketmine\entity\Villager;
use pocketmine\entity\Location;
use pocketmine\event\block\BlockSpreadEvent;
use pocketmine\item\Fertilizer;
use pocketmine\item\Hoe;
use pocketmine\item\Item;
use pocketmine\item\Shovel;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\Random;
use pocketmine\world\World;
use pocketmine\world\generator\object\TallGrass as TallGrassObject;
use pocketmine\world\sound\ItemUseOnBlockSound;
use function mt_rand;

class Grass extends Opaque{

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaBlocks::DIRT()->asItem()
		];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	public function ticksRandomly() : bool{
		return true;
	} 
	public function isDayTime(World $world) : bool {
		return $world->getSunAngleDegrees() < 90 or $world->getSunAngleDegrees() > 270;
	}
	public function izinverilencheck(){
		 $otomobspawnizinverilencheck = $this->position->getWorld()->getServer()->getWallnerBoolConfig("oto-mob-spawn-sadece-izin-verilen-dunyalar");
		if($otomobspawnizinverilencheck == true){
			$dunyaismi = $this->position->getWorld()->getFolderName();
		if($this->position->getWorld()->getServer()->izinverilendunya($dunyaismi)){
			return "spawnla";
		}else{
			return "spawnlama";
		}

		}
	}
		public function izinverilmeyencheck(){
		 
		$otomobspawnizinverilmeyencheck = $this->position->getWorld()->getServer()->getWallnerBoolConfig("oto-mob-spawn-izin-verilmeyen-dunyalar");
		if($otomobspawnizinverilmeyencheck == true){
			$dunyaismi = $this->position->getWorld()->getFolderName();
		if($this->position->getWorld()->getServer()->izinverilmeyendunya($dunyaismi)){
			return "spawnlama";
		}else{
			return "spawnla";
		}

		}
	}
	public function spawnmob(){
		$otomobspawncheck = $this->position->getWorld()->getServer()->getWallnerBoolConfig("oto-mob-spawn");
		
		if($otomobspawncheck == true){

			 foreach($this->position->getWorld()->getServer()->getOnlinePlayers() as $player){
            if ($player->getPosition()->distance($this->getPosition()) < 11){
            	if($this->isDayTime($this->position->getWorld())){


            	$rastgele = rand(1, 90);
            	switch($rastgele){
                    case 1:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Sheep($pos);
		break;
		case 2:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Cow($pos);
		break;
		case 3:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Chicken($pos);
		break;
		case 4:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Pig($pos);
		break;
		case 5:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Rabbit($pos);
		break;
		case 6:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Horse($pos);
		break;
		case 7:
		$pos = new Location($this->position->x, $this->position->y + 5, $this->position->z, $this->position->getWorld(), 0, 0);
		new Bee($pos);
		break;
	}
}else{
	            $rastgelec = rand(1, 90);
            	switch($rastgelec){
                    case 1:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Zombie($pos);
		break;
		case 2:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Skeleton($pos);
		break;
		case 3:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new ZombieVillager($pos);
		break;
		case 4:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Spider($pos);
		break;
		case 5:
		$pos = new Location($this->position->x, $this->position->y + 5, $this->position->z, $this->position->getWorld(), 0, 0);
		new Phantom($pos);
		break;
		case 6:
		$pos = new Location($this->position->x, $this->position->y + 1, $this->position->z, $this->position->getWorld(), 0, 0);
		new Creeper($pos);
		break;
	}
}
}
}
}
}

	public function onRandomTick() : void{
		$otomobspawnizinverilmeyencheck = $this->position->getWorld()->getServer()->getWallnerBoolConfig("oto-mob-spawn-izin-verilmeyen-dunyalar");
		$otomobspawnizinverilencheck = $this->position->getWorld()->getServer()->getWallnerBoolConfig("oto-mob-spawn-sadece-izin-verilen-dunyalar");
		if($otomobspawnizinverilmeyencheck == true and $otomobspawnizinverilencheck == true){
		
       }else{
       	if($otomobspawnizinverilmeyencheck == true){
       		$kontrol2 = $this->izinverilmeyencheck();
       		if($kontrol2 === "spawnlama"){

       		}else{
       			if($kontrol2 === "spawnla"){
       				$this->spawnmob();
       			}
       		}

       }
       if($otomobspawnizinverilencheck == true){
       		$kontrol = $this->izinverilencheck();
       		if($kontrol === "spawnlama"){

       		}else{
       			if($kontrol === "spawnla"){
       				$this->spawnmob();
       			}
       		}

       }
   }
   if($otomobspawnizinverilmeyencheck == false and $otomobspawnizinverilencheck == false){
   	$this->spawnmob();
   }

		$lightAbove = $this->position->getWorld()->getFullLightAt($this->position->x, $this->position->y + 1, $this->position->z);
		if($lightAbove < 4 && $this->position->getWorld()->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z)->getLightFilter() >= 2){
			//grass dies
			$ev = new BlockSpreadEvent($this, $this, VanillaBlocks::DIRT());
			$ev->call();
			if(!$ev->isCancelled()){
				$this->position->getWorld()->setBlock($this->position, $ev->getNewState(), false);
			}
		}elseif($lightAbove >= 9){
			//try grass spread
			for($i = 0; $i < 4; ++$i){
				$x = mt_rand($this->position->x - 1, $this->position->x + 1);
				$y = mt_rand($this->position->y - 3, $this->position->y + 1);
				$z = mt_rand($this->position->z - 1, $this->position->z + 1);

				$b = $this->position->getWorld()->getBlockAt($x, $y, $z);
				if(
					!($b instanceof Dirt) ||
					$b->isCoarse() ||
					$this->position->getWorld()->getFullLightAt($x, $y + 1, $z) < 4 ||
					$this->position->getWorld()->getBlockAt($x, $y + 1, $z)->getLightFilter() >= 2
				){
					continue;
				}

				$ev = new BlockSpreadEvent($b, $this, VanillaBlocks::GRASS());
				$ev->call();
				if(!$ev->isCancelled()){
					$this->position->getWorld()->setBlock($b->position, $ev->getNewState(), false);
				}
			}
		}
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($face !== Facing::UP){
			return false;
		}
		if($item instanceof Fertilizer){
			$item->pop();
			TallGrassObject::growGrass($this->position->getWorld(), $this->position, new Random(mt_rand()), 8, 2);

			return true;
		}elseif($item instanceof Hoe){
			$item->applyDamage(1);
			$newBlock = VanillaBlocks::FARMLAND();
			$this->position->getWorld()->addSound($this->position->add(0.5, 0.5, 0.5), new ItemUseOnBlockSound($newBlock));
			$this->position->getWorld()->setBlock($this->position, $newBlock);

			return true;
		}elseif($item instanceof Shovel && $this->getSide(Facing::UP)->getId() === BlockLegacyIds::AIR){
			$item->applyDamage(1);
			$newBlock = VanillaBlocks::GRASS_PATH();
			$this->position->getWorld()->addSound($this->position->add(0.5, 0.5, 0.5), new ItemUseOnBlockSound($newBlock));
			$this->position->getWorld()->setBlock($this->position, $newBlock);

			return true;
		}

		return false;
	}
}
