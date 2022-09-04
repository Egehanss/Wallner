<?php


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

	public function hasEntityCollision() : bool{
		return true;
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
	$sans = $this->position->getWorld()->getServer()->getWallnerIntConfig("seker-kamisi-buyume-sansi");
    $oran = rand(1, $sans);
    switch($oran){
    	case 1:
    	$kontrol = $this->blockkontrol();
    	if($kontrol === "dropla" or $kontrol === "dropla2" or $kontrol === "dropla3" or $kontrol === "dropla4" or $kontrol === "dropla5"){
    		$positionblock = new Vector3($this->position->x, $this->position->y, $this->position->z);
		$this->position->getWorld()->dropItem($positionblock, ItemFactory::getInstance()->get(338, 0, 1), new Vector3(0, 0, 0));
						 }
						 if($kontrol === "buyut"){
                       $this->sekerkamisinibuyut();
						 }
     
    	break;
    }
	}
    public function sekerkamisinibuyut(){
    $world = $this->position->getWorld();
    $positionblock = new Vector3($this->position->x, $this->position->y + 1, $this->position->z);
    $world->setBlock($positionblock, VanillaBlocks::SUGARCANE());
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

 	    if($block1->getId() == Ids::REEDS_BLOCK){
 	    	if($block2->getId() == Ids::REEDS_BLOCK){
 	    		if($block3->getId() == Ids::REEDS_BLOCK){
 	    			if($block4->getId() == Ids::SAND or $block4->getId() == Ids::GRASS or $block4->getId() == Ids::DIRT or $block4->getId() == Ids::PODZOL){
 	    				return "uygundegil";
 	    		}
 	    	}

 	    }
 	} 
 	if($block1->getId() == Ids::REEDS_BLOCK){
 	    	if($block2->getId() == Ids::AIR){
 	    			if($block4->getId() == Ids::SAND or $block4->getId() == Ids::GRASS or $block4->getId() == Ids::DIRT or $block4->getId() == Ids::PODZOL){
 	    				return "uygun";
 	    		}

 	    }
 	}
 	    			if($block5->getId() == Ids::SAND or $block5->getId() == Ids::GRASS or $block5->getId() == Ids::DIRT or $block5->getId() == Ids::PODZOL){
 	    				if($block4->getId() == Ids::REEDS_BLOCK){
 	    					if($block2->getId() == Ids::AIR){
 	    				return "uygun";
 	    		}
 	    	}
 	    	}

	}
	public function blockkontrol(){

       	   $world = $this->position->getWorld();
       	   $level = $this->position->getWorld();
       	   $positionblock = new Vector3($this->position->x, $this->position->y, $this->position->z);




 	            $blockyeni = $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z + 1); #en sağ
				$blockyeni2 = $world->getBlockAt($this->position->x + 1, $this->position->y + 1, $this->position->z); #bi blok ileri
				$blockyeni3 = $world->getBlockAt($this->position->x - 1, $this->position->y + 1, $this->position->z); #bi blok geri
				$blockyeni4 = $world->getBlockAt($this->position->x, $this->position->y + 1, $this->position->z - 1); #en sol

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