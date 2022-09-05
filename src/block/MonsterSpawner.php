<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\SupportType;
use pocketmine\block\tile\MonsterSpawner as MonsterSP;
use pocketmine\tile\Tile;
use pocketmine\data\bedrock\LegacyEntityIdToStringIdMap;
use pocketmine\entity\Living;
use pocketmine\entity\Location;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\item\ToolTier;
use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\BlockToolType;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\entity\Entity;
use pocketmine\item\SpawnEgg;
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
use pocketmine\world\World;

use function mt_rand;

class MonsterSpawner extends Transparent{

         protected int $entityId; 

    public function __construct()
    {
        parent::__construct(new BlockIdentifier(BlockLegacyIds::MOB_SPAWNER, 0, null, MonsterSP::class), "Monster Spawner", new BlockBreakInfo(5.0, BlockToolType::PICKAXE, ToolTier::WOOD()->getHarvestLevel()));
    }

    public function isAffectedBySilkTouch(): bool {
        return true;
    }

    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
        if($item->getNamedTag()->getTag("EntityId") !== null) {
            $this->entityId = $item->getNamedTag()->getInt("EntityId", -1);
            if($this->entityId > 10) {
                $this->generateSpawnerTile();
            }
        }
        return true;
    }
 
        public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
            
        
        if($item instanceof SpawnEgg){
            if($player instanceof Player){
                
            $tile = $this->getPosition()->getWorld()->getTile($this->getPosition());
                    if(!$tile instanceof MonsterSP) {
            $tile = new MonsterSP($this->getPosition()->getWorld(), $this->getPosition());
        }
        $tile->setEntityId($item->getMeta());
        $tile->writeSaveData(new CompoundTag());
        $this->onScheduledUpdate();
        $this->getPosition()->getWorld()->addTile($tile);

            $nbt = new CompoundTag();
            $nbt->setInt("EntityId", (int)$tile->getEntityId());
           
            $blockk = $this->getPosition()->getWorld()->getBlock(new Vector3((int) $this->getPosition()->getFloorX(), (int) $this->getPosition()->getFloorY(), (int) $this->getPosition()->getFloorZ()));

            $this->getPosition()->getWorld()->setBlock($this->getPosition(), $blockk);

           
                $item->pop();
                $player->getInventory()->setItemInHand($item); 
            
}
}
        return true;
    }

    private function generateSpawnerTile(): void {
        $tile = $this->getPosition()->getWorld()->getTile($this->getPosition());

        if(!$tile instanceof MonsterSP) {
            $tile = new MonsterSP($this->getPosition()->getWorld(), $this->getPosition());
        }
        $tile->setEntityId($this->entityId);
        $tile->writeSaveData(new CompoundTag());
        $this->onScheduledUpdate();
        $this->getPosition()->getWorld()->addTile($tile);
    }


    public function onScheduledUpdate(): void{
        $tile = $this->getPosition()->getWorld()->getTile($this->getPosition());
        if(!$tile instanceof MonsterSP){
            return;
        }
        if($tile->getTick() > 0) $tile->decreaseTick();
        if($tile->isValidEntity() && $tile->canEntityGenerate() && $tile->getTick() <= 0){
            $tile->setTick(20);
            if($tile->getSpawnDelay() > 0 ){
                $tile->decreaseSpawnDelay();
            }else{
                $tile->setSpawnDelay($tile->getMinSpawnDelay() + mt_rand(0, min(0, $tile->getMaxSpawnDelay() - $tile->getMinSpawnDelay())));
                for($i = 0; $i < $tile->getSpawnCount(); $i++){
                    $pos = $tile->getPosition();
                    $pos = new Location($pos->x + mt_rand(1, 2), $pos->y + 1, $pos->z + mt_rand(1, 2), $pos->getWorld(), 0, 0);
                    
                    
    
                    
                    if($tile->getEntityId() == 10){
                        $entity = $this->createChicken($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 11){
                        $entity = $this->createCow($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 12){
                        $entity = $this->createPig($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 13){
                        $entity = $this->createSheep($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 14){
                        $entity = $this->createWolf($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 15){
                        $entity = $this->createVillager($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 16){
                        $entity = $this->createMooshroom($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 17){
                        $entity = $this->createSquid($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 18){
                        $entity = $this->createRabbit($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 19){
                        $entity = $this->createBat($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 20){
                        $entity = $this->createIronGolem($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 22){
                        $entity = $this->createOcelot($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 23){
                        $entity = $this->createHorse($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 24){
                        $entity = $this->createDonkey($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 26){
                        $entity = $this->createSkeletonHorse($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 28){
                        $entity = $this->createPolarBear($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 29){
                        $entity = $this->createLlama($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 30){
                        $entity = $this->createParrot($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 31){
                        $entity = $this->createDolphin($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 32){
                        $entity = $this->createZombie($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 33){
                        $entity = $this->createCreeper($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 34){
                        $entity = $this->createSkeleton($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 35){
                        $entity = $this->createSpider($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 37){
                        $entity = $this->createSlime($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 38){
                        $entity = $this->createEnderman($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 39){
                        $entity = $this->createSilverfish($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 40){
                        $entity = $this->createCaveSpider($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 41){
                        $entity = $this->createGhast($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 42){
                        $entity = $this->createMagmaCube($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 43){
                        $entity = $this->createBlaze($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 44){
                        $entity = $this->createZombieVillager($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 45){
                        $entity = $this->createWitch($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 46){
                        $entity = $this->createStray($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 47){
                        $entity = $this->createHusk($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 49){
                        $entity = $this->createGuardian($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 50){
                        $entity = $this->createElderGuardian($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 57){
                        $entity = $this->createVindicator($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 58){
                        $entity = $this->createPhantom($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 75){
                        $entity = $this->createCat($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 104){
                        $entity = $this->createEvoker($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 109){
                        $entity = $this->createSalmon($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 110){
                        $entity = $this->createDrowned($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 111){
                        $entity = $this->createTropicalFish($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }
                    if($tile->getEntityId() == 113){
                        $entity = $this->createCod($this->position->getWorld(), $this->position->add(mt_rand(-1, 1), 1, mt_rand(-1, 1)), lcg_value() * 360, 0);
                        $entity->spawnToAll();
                    }

                    $i++;
                }
            }
        }
        $this->position->getWorld()->scheduleDelayedBlockUpdate($this->position, 1);
    }



            public function createCod(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new Cod(Location::fromObject($pos, $world, $yaw, $pitch));
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