<?php


declare(strict_types=1);

namespace pocketmine\entity\mobs;

class Attributes {

	public function AggressiveCreatures(string $name) : bool {
		return in_array($name, [
			"Zombie", "CaveSpider", "Spider", "Guardian", "ElderGuardian", "Slime", "Stray", "Witch", "Wolf", "Blaze", "ZombieVillager", "Drowned", "Vindicator", "Husk", "Evoker"
		]);
	}
	public function isFlying(string $name) : bool {
		return in_array($name, ["Parrot", "Bat", "Bee", "Phantom"]);
	}
	public function canBeCaughtinSunLight(string $name) : bool { #güneş ışığı tarafından ateşe verilen canlılar
		return in_array($name, ["Zombie", "Skeleton", "ZombieVillager", "Phantom"]); 
	}
	public function isJumping(string $name) : bool {
		return in_array($name, ["Rabbit", "Slime"]);
	}
	public function isSwimming(string $name) : bool {
		return in_array($name, ["Cod", "Dolphin", "ElderGuardian", "PufferFish", "Salmon", "Squid", "TropicalFish", "Axolotl", "Drowned"]);
	}
	public function isSnowMonster(string $name) : bool {
		return in_array($name, ["SnowGolem"]);
	}
	public function isCreeper(string $name) : bool {
		return in_array($name, ["Creeper"]);
	}
	public function isSkeleton(string $name) : bool {
		return in_array($name, ["Skeleton"]);
	}
	public function getEnemyAttack(string $name) : string {
		$dusmanlar = array("Zombie" => "Villager", "Wolf" => "Sheep", "Fox" => "Rabbit", "Fox" => "Chicken");
		foreach ($dusmanlar as $kaynak => $hedef) {
			if ($kaynak === $name) {
				return $hedef;
			}
		}
		return "yok";
	}
} 