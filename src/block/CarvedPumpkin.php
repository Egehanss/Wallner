<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\world\BlockTransaction;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\block\BlockLegacyIds as Ids;
use pocketmine\block\VanillaBlocks;
use pocketmine\entity\SnowGolem;
use pocketmine\entity\Location;
use pocketmine\player\Player;
use pocketmine\world\World;
use pocketmine\entity\Entity;

class CarvedPumpkin extends Opaque{
	use FacesOppositePlacingPlayerTrait;
	use HorizontalFacingTrait;
 
	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->facing = BlockDataSerializer::readLegacyHorizontalFacing($stateMeta & 0x03);
	}

	protected function writeStateToMeta() : int{
		return BlockDataSerializer::writeLegacyHorizontalFacing($this->facing);
	}

	public function getStateBitmask() : int{
		return 0b11;
	}
    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
      
        $kontrol = $this->checkkardanadam($this->position->x, $this->position->y, $this->position->z, $this->position->getWorld()->getFolderName());
        if($kontrol === "kardanadamyap"){
          $this->kardanadamyap();
          return false;
        }else{
          return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
        }
        
        
    }
    public function checkkardanadam(int $xx, int $yy, int $zz, string $worldfoldername){

           $world = $this->position->getWorld()->getServer()->getWorldManager()->getWorldByName($worldfoldername);
           $positionblock = new Vector3($xx, $yy, $zz);
           $positionblock2 = new Vector3($xx, $yy - 1, $zz);
           $positionblock3 = new Vector3($xx, $yy - 2, $zz);

           $blockyeni = $world->getBlockAt($xx, $yy - 1, $zz);
           $blockyeni2 = $world->getBlockAt($xx, $yy - 2, $zz);

           if($blockyeni->getId() == Ids::SNOW_BLOCK){
            if($blockyeni2->getId() == Ids::SNOW_BLOCK){
                $world->setBlock($positionblock, VanillaBlocks::AIR());
                $world->setBlock($positionblock2, VanillaBlocks::AIR());
                $world->setBlock($positionblock3, VanillaBlocks::AIR());
                return "kardanadamyap";
           }
           }

    }
    public function kardanadamyap(){

        $entity = $this->createSnowGolem($this->position->getWorld(), $this->position->add(0.5, 0, 0.5), lcg_value() * 360, 0);
        $entity->spawnToAll();

        $positionblock = new Vector3($this->position->x, $this->position->y, $this->position->z);
        $world = $this->position->getWorld();
        $world->setBlock($positionblock, VanillaBlocks::AIR());

    }
    public function createSnowGolem(World $world, Vector3 $pos, float $yaw, float $pitch) : Entity{
                return new SnowGolem(Location::fromObject($pos, $world, $yaw, $pitch));
            }
}
