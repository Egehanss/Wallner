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
use pocketmine\entity\Entity;

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


            	$rastgele = rand(1, 200);
            	switch($rastgele){
                    case 1:
		$entity = $this->createSheep($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 2:
		$entity = $this->createCow($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 3:
		$entity = $this->createChicken($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 4:
		$entity = $this->createPig($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 5:
		$entity = $this->createRabbit($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 6:
		$entity = $this->createHorse($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 7:
		$entity = $this->createBee($this->position->getWorld(), $this->position->add(0.5, 5, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
	}
}else{
	            $rastgelec = rand(1, 200);
            	switch($rastgelec){
                    case 1:
		$entity = $this->createZombie($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 2:
		$entity = $this->createSkeleton($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 3:
		$entity = $this->createZombieVillager($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 4:
		$entity = $this->createSpider($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 5:
		$entity = $this->createPhantom($this->position->getWorld(), $this->position->add(0.5, 5, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
		break;
		case 6:
		$entity = $this->createCreeper($this->position->getWorld(), $this->position->add(0.5, 1, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();
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
	            public function createCod(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Cod(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createBee(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Bee(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createTropicalFish(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new TropicalFish(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createDrowned(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Drowned(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createSalmon(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Salmon(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createEvoker(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Evoker(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createCat(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Cat(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createPhantom(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Phantom(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createVindicator(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Vindicator(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createElderGuardian(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new ElderGuardian(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createGuardian(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Guardian(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createHusk(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Husk(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createStray(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Stray(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createWitch(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Witch(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createZombieVillager(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new ZombieVillager(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createBlaze(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Blaze(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createMagmaCube(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new MagmaCube(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createGhast(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Ghast(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createCaveSpider(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new CaveSpider(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createSilverfish(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Silverfish(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createEnderman(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Enderman(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createSlime(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Slime(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createSpider(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Spider(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createSkeleton(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Skeleton(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createCreeper(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Creeper(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createZombie(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Zombie(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createDolphin(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Dolphin(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createParrot(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Parrot(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createLlama(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Llama(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createPolarBear(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new PolarBear(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createSkeletonHorse(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new SkeletonHorse(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createDonkey(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Donkey(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createHorse(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Horse(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createOcelot(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Ocelot(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createIronGolem(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new IronGolem(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createBat(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Bat(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createRabbit(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Rabbit(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createSquid(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Squid(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createMooshroom(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Mooshroom(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createVillager(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Villager(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createWolf(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Wolf(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createSheep(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Sheep(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createPig(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Pig(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createCow(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Cow(Location::fromObject($pos, $world, $yaw, $pitch));
            }
            public function createChicken(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Chicken(Location::fromObject($pos, $world, $yaw, $pitch));
            }
}
