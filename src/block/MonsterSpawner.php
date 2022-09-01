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
                    $x = ((mt_rand(-5, 5) / 5) * $tile->getSpawnRange()) + 0.5;
                    $z = ((mt_rand(-5, 5) / 5) * $tile->getSpawnRange()) + 0.5;
                    $pos = $tile->getPosition();
                    $pos = new Location($pos->x + $x, $pos->y + mt_rand(1, 3), $pos->z + $z, $pos->getWorld(), 0, 0);
                    
                    
    
                    
                    if($tile->getEntityId() == 10){
                        new Chicken($pos);
                    }
                    if($tile->getEntityId() == 11){
                        new Cow($pos);
                    }
                    if($tile->getEntityId() == 12){
                        new Pig($pos);
                    }
                    if($tile->getEntityId() == 13){
                        new Sheep($pos);
                    }
                    if($tile->getEntityId() == 14){
                        new Wolf($pos);
                    }
                    if($tile->getEntityId() == 15){
                        new Villager($pos);
                    }
                    if($tile->getEntityId() == 16){
                        new Mooshroom($pos);
                    }
                    if($tile->getEntityId() == 17){
                        new Squid($pos);
                    }
                    if($tile->getEntityId() == 18){
                        new Rabbit($pos);
                    }
                    if($tile->getEntityId() == 19){
                        new Bat($pos);
                    }
                    if($tile->getEntityId() == 20){
                        new IronGolem($pos);
                    }
                    if($tile->getEntityId() == 22){
                        new Ocelot($pos);
                    }
                    if($tile->getEntityId() == 23){
                        new Horse($pos);
                    }
                    if($tile->getEntityId() == 24){
                        new Donkey($pos);
                    }
                    if($tile->getEntityId() == 26){
                        new SkeletonHorse($pos);
                    }
                    if($tile->getEntityId() == 28){
                        new PolarBear($pos);
                    }
                    if($tile->getEntityId() == 29){
                        new Llama($pos);
                    }
                    if($tile->getEntityId() == 30){
                        new Parrot($pos);
                    }
                    if($tile->getEntityId() == 31){
                        new Dolphin($pos);
                    }
                    if($tile->getEntityId() == 32){
                        new Zombie($pos);
                    }
                    if($tile->getEntityId() == 33){
                        new Creeper($pos);
                    }
                    if($tile->getEntityId() == 34){
                        new Skeleton($pos);
                    }
                    if($tile->getEntityId() == 35){
                        new Spider($pos);
                    }
                    if($tile->getEntityId() == 37){
                        new Slime($pos);
                    }
                    if($tile->getEntityId() == 38){
                        new Enderman($pos);
                    }
                    if($tile->getEntityId() == 39){
                        new Silverfish($pos);
                    }
                    if($tile->getEntityId() == 40){
                        new CaveSpider($pos);
                    }
                    if($tile->getEntityId() == 41){
                        new Ghast($pos);
                    }
                    if($tile->getEntityId() == 42){
                        new MagmaCube($pos);
                    }
                    if($tile->getEntityId() == 43){
                        new Blaze($pos);
                    }
                    if($tile->getEntityId() == 44){
                        new ZombieVillager($pos);
                    }
                    if($tile->getEntityId() == 45){
                        new Witch($pos);
                    }
                    if($tile->getEntityId() == 46){
                        new Stray($pos);
                    }
                    if($tile->getEntityId() == 47){
                        new Husk($pos);
                    }
                    if($tile->getEntityId() == 49){
                        new Guardian($pos);
                    }
                    if($tile->getEntityId() == 50){
                        new ElderGuardian($pos);
                    }
                    if($tile->getEntityId() == 57){
                        new Vindicator($pos);
                    }
                    if($tile->getEntityId() == 58){
                        new Phantom($pos);
                    }
                    if($tile->getEntityId() == 75){
                        new Cat($pos);
                    }
                    if($tile->getEntityId() == 104){
                        new Evoker($pos);
                    }
                    if($tile->getEntityId() == 109){
                        new Salmon($pos);
                    }
                    if($tile->getEntityId() == 110){
                        new Drowned($pos);
                    }
                    if($tile->getEntityId() == 111){
                        new TropicalFish($pos);
                    }
                    if($tile->getEntityId() == 113){
                        new Cod($pos);
                    }

                    $i++;
                }
            }
        }
        $this->position->getWorld()->scheduleDelayedBlockUpdate($this->position, 1);
    }
}