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

namespace pocketmine\entity;

use DaveRandom\CallbackValidator\CallbackType;
use DaveRandom\CallbackValidator\ParameterType;
use DaveRandom\CallbackValidator\ReturnType;
use pocketmine\block\BlockFactory;
use pocketmine\data\bedrock\EntityLegacyIds as LegacyIds;
use pocketmine\data\bedrock\PotionTypeIdMap;
use pocketmine\data\bedrock\PotionTypeIds;
use pocketmine\data\SavedDataLoadingException;
use pocketmine\entity\EntityDataHelper as Helper;
use pocketmine\entity\object\ExperienceOrb;
use pocketmine\entity\object\FallingBlock;
use pocketmine\entity\object\ItemEntity;
use pocketmine\entity\object\Painting;
use pocketmine\entity\object\PaintingMotive;
use pocketmine\entity\object\PrimedTNT;
use pocketmine\entity\projectile\Arrow;
use pocketmine\entity\projectile\Egg;
use pocketmine\entity\projectile\EnderPearl;
use pocketmine\entity\projectile\ExperienceBottle;
use pocketmine\entity\projectile\Snowball;
use pocketmine\entity\projectile\SplashPotion;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3; 
use pocketmine\nbt\NbtException;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\Utils;
use pocketmine\world\World;
use pocketmine\entity\MobsEntity;
use function count;
use function reset;

/**
 * This class manages the creation of entities loaded from disk.
 * You need to register your entity into this factory if you want to load/save your entity on disk (saving with chunks).
 */
final class EntityFactory{
	use SingletonTrait;

	/**
	 * @var \Closure[] save ID => creator function
	 * @phpstan-var array<int|string, \Closure(World, CompoundTag) : Entity>
	 */
	private array $creationFuncs = [];
	/**
	 * @var string[]
	 * @phpstan-var array<class-string<Entity>, string>
	 */
	private array $saveNames = [];

	public function __construct(){
		//define legacy save IDs first - use them for saving for maximum compatibility with Minecraft PC
		//TODO: index them by version to allow proper multi-save compatibility

		$this->register(Arrow::class, function(World $world, CompoundTag $nbt) : Arrow{
			return new Arrow(Helper::parseLocation($nbt, $world), null, $nbt->getByte(Arrow::TAG_CRIT, 0) === 1, $nbt);
		}, ['Arrow', 'minecraft:arrow'], LegacyIds::ARROW);

		$this->register(Egg::class, function(World $world, CompoundTag $nbt) : Egg{
			return new Egg(Helper::parseLocation($nbt, $world), null, $nbt);
		}, ['Egg', 'minecraft:egg'], LegacyIds::EGG);

		$this->register(EnderPearl::class, function(World $world, CompoundTag $nbt) : EnderPearl{
			return new EnderPearl(Helper::parseLocation($nbt, $world), null, $nbt);
		}, ['ThrownEnderpearl', 'minecraft:ender_pearl'], LegacyIds::ENDER_PEARL);

		$this->register(ExperienceBottle::class, function(World $world, CompoundTag $nbt) : ExperienceBottle{
			return new ExperienceBottle(Helper::parseLocation($nbt, $world), null, $nbt);
		}, ['ThrownExpBottle', 'minecraft:xp_bottle'], LegacyIds::XP_BOTTLE);

		$this->register(ExperienceOrb::class, function(World $world, CompoundTag $nbt) : ExperienceOrb{
			$value = 1;
			if(($valuePcTag = $nbt->getTag(ExperienceOrb::TAG_VALUE_PC)) instanceof ShortTag){ //PC
				$value = $valuePcTag->getValue();
			}elseif(($valuePeTag = $nbt->getTag(ExperienceOrb::TAG_VALUE_PE)) instanceof IntTag){ //PE save format
				$value = $valuePeTag->getValue();
			}

			return new ExperienceOrb(Helper::parseLocation($nbt, $world), $value, $nbt);
		}, ['XPOrb', 'minecraft:xp_orb'], LegacyIds::XP_ORB);

		$this->register(FallingBlock::class, function(World $world, CompoundTag $nbt) : FallingBlock{
			return new FallingBlock(Helper::parseLocation($nbt, $world), FallingBlock::parseBlockNBT(BlockFactory::getInstance(), $nbt), $nbt);
		}, ['FallingSand', 'minecraft:falling_block'], LegacyIds::FALLING_BLOCK);

		$this->register(ItemEntity::class, function(World $world, CompoundTag $nbt) : ItemEntity{
			$itemTag = $nbt->getCompoundTag("Item");
			if($itemTag === null){
				throw new SavedDataLoadingException("Expected \"Item\" NBT tag not found");
			}

			$item = Item::nbtDeserialize($itemTag);
			if($item->isNull()){
				throw new SavedDataLoadingException("Item is invalid");
			}
			return new ItemEntity(Helper::parseLocation($nbt, $world), $item, $nbt);
		}, ['Item', 'minecraft:item'], LegacyIds::ITEM);

		$this->register(Painting::class, function(World $world, CompoundTag $nbt) : Painting{
			$motive = PaintingMotive::getMotiveByName($nbt->getString("Motive"));
			if($motive === null){
				throw new SavedDataLoadingException("Unknown painting motive");
			}
			$blockIn = new Vector3($nbt->getInt("TileX"), $nbt->getInt("TileY"), $nbt->getInt("TileZ"));
			if(($directionTag = $nbt->getTag("Direction")) instanceof ByteTag){
				$facing = Painting::DATA_TO_FACING[$directionTag->getValue()] ?? Facing::NORTH;
			}elseif(($facingTag = $nbt->getTag("Facing")) instanceof ByteTag){
				$facing = Painting::DATA_TO_FACING[$facingTag->getValue()] ?? Facing::NORTH;
			}else{
				throw new SavedDataLoadingException("Missing facing info");
			}

			return new Painting(Helper::parseLocation($nbt, $world), $blockIn, $facing, $motive, $nbt);
		}, ['Painting', 'minecraft:painting'], LegacyIds::PAINTING);

		$this->register(PrimedTNT::class, function(World $world, CompoundTag $nbt) : PrimedTNT{
			return new PrimedTNT(Helper::parseLocation($nbt, $world), $nbt);
		}, ['PrimedTnt', 'PrimedTNT', 'minecraft:tnt'], LegacyIds::TNT);

		$this->register(Snowball::class, function(World $world, CompoundTag $nbt) : Snowball{
			return new Snowball(Helper::parseLocation($nbt, $world), null, $nbt);
		}, ['Snowball', 'minecraft:snowball'], LegacyIds::SNOWBALL);

		$this->register(SplashPotion::class, function(World $world, CompoundTag $nbt) : SplashPotion{
			$potionType = PotionTypeIdMap::getInstance()->fromId($nbt->getShort("PotionId", PotionTypeIds::WATER));
			if($potionType === null){
				throw new SavedDataLoadingException("No such potion type");
			}
			return new SplashPotion(Helper::parseLocation($nbt, $world), null, $potionType, $nbt);
		}, ['ThrownPotion', 'minecraft:potion', 'thrownpotion'], LegacyIds::SPLASH_POTION);

		$this->register(Squid::class, function(World $world, CompoundTag $nbt) : Squid{
			return new Squid(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Squid', 'minecraft:squid'], LegacyIds::SQUID);

		$this->register(Villager::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Villager(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Villager', 'minecraft:villager'], LegacyIds::VILLAGER);

		$this->register(Zombie::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Zombie(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Zombie', 'minecraft:zombie'], LegacyIds::ZOMBIE); 

		$this->register(Sheep::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Sheep(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Sheep', 'minecraft:sheep'], LegacyIds::SHEEP);

		$this->register(ZombieVillager::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new ZombieVillager(Helper::parseLocation($nbt, $world), $nbt);
		}, ['ZombieVillager', 'minecraft:zombievillager'], LegacyIds::ZOMBIE_VILLAGER);

		$this->register(Wolf::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Wolf(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Wolf', 'minecraft:wolf'], LegacyIds::WOLF);

		$this->register(Witch::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Witch(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Witch', 'minecraft:witch'], LegacyIds::WITCH); 

		$this->register(Vindicator::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Vindicator(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Vindicator', 'minecraft:vindicator'], LegacyIds::VINDICATOR);

		$this->register(TropicalFish::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new TropicalFish(Helper::parseLocation($nbt, $world), $nbt);
		}, ['TropicalFish', 'minecraft:tropicalfish'], LegacyIds::TROPICALFISH);

		$this->register(Stray::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Stray(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Stray', 'minecraft:stray'], LegacyIds::STRAY);

		$this->register(Spider::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Spider(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Spider', 'minecraft:spider'], LegacyIds::SPIDER);

		$this->register(Slime::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Slime(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Slime', 'minecraft:slime'], LegacyIds::SLIME);

		$this->register(SkeletonHorse::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new SkeletonHorse(Helper::parseLocation($nbt, $world), $nbt);
		}, ['SkeletonHorse', 'minecraft:skeletonhorse'], LegacyIds::SKELETON_HORSE);

		$this->register(Skeleton::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Skeleton(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Skeleton', 'minecraft:skeleton'], LegacyIds::SKELETON);

		$this->register(Silverfish::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Silverfish(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Silverfish', 'minecraft:silverfish'], LegacyIds::SILVERFISH);

		$this->register(Salmon::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Salmon(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Salmon', 'minecraft:salmon'], LegacyIds::SALMON);

		$this->register(Rabbit::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Rabbit(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Rabbit', 'minecraft:rabbit'], LegacyIds::RABBIT);

		$this->register(PufferFish::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new PufferFish(Helper::parseLocation($nbt, $world), $nbt);
		}, ['PufferFish', 'minecraft:pufferfish'], LegacyIds::PUFFERFISH);

		$this->register(PolarBear::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new PolarBear(Helper::parseLocation($nbt, $world), $nbt);
		}, ['PolarBear', 'minecraft:polarbear'], LegacyIds::POLAR_BEAR);

		$this->register(Pig::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Pig(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Pig', 'minecraft:pig'], LegacyIds::PIG);

		$this->register(Phantom::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Phantom(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Phantom', 'minecraft:phantom'], LegacyIds::PHANTOM);

		$this->register(Parrot::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Parrot(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Parrot', 'minecraft:parrot'], LegacyIds::PARROT);

		$this->register(Ocelot::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Ocelot(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Ocelot', 'minecraft:ocelot'], LegacyIds::OCELOT);

		$this->register(Mooshroom::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Mooshroom(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Mooshroom', 'minecraft:mooshroom'], LegacyIds::MOOSHROOM);

		$this->register(MagmaCube::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new MagmaCube(Helper::parseLocation($nbt, $world), $nbt);
		}, ['MagmaCube', 'minecraft:magmacube'], LegacyIds::MAGMA_CUBE);

		$this->register(Llama::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Llama(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Llama', 'minecraft:llama'], LegacyIds::LLAMA_SPIT);

		$this->register(IronGolem::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new IronGolem(Helper::parseLocation($nbt, $world), $nbt);
		}, ['IronGolem', 'minecraft:irongolem'], LegacyIds::IRON_GOLEM);

		$this->register(Husk::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Husk(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Husk', 'minecraft:husk'], LegacyIds::HUSK);

		$this->register(Horse::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Horse(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Horse', 'minecraft:horse'], LegacyIds::HORSE);

		$this->register(Guardian::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Guardian(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Guardian', 'minecraft:guardian'], LegacyIds::GUARDIAN);

		$this->register(Ghast::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Ghast(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Ghast', 'minecraft:ghast'], LegacyIds::GHAST);

		#$this->register(Fox::class, function(World $world, CompoundTag $nbt) : MobsEntity{
		#	return new Fox(Helper::parseLocation($nbt, $world), $nbt);
		#}, ['Fox', 'minecraft:fox'], LegacyIds::FOX);

		$this->register(Evoker::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Evoker(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Evoker', 'minecraft:evoker'], LegacyIds::EVOCATION_ILLAGER);

		$this->register(Enderman::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Enderman(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Enderman', 'minecraft:enderman'], LegacyIds::ENDERMAN);

		$this->register(ElderGuardian::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new ElderGuardian(Helper::parseLocation($nbt, $world), $nbt);
		}, ['ElderGuardian', 'minecraft:elderguardian'], LegacyIds::ELDER_GUARDIAN);

		$this->register(Drowned::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Drowned(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Drowned', 'minecraft:drowned'], LegacyIds::DROWNED);

		$this->register(Donkey::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Donkey(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Donkey', 'minecraft:donkey'], LegacyIds::DONKEY);

		$this->register(Dolphin::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Dolphin(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Dolphin', 'minecraft:dolphin'], LegacyIds::DOLPHIN);

		$this->register(Creeper::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Creeper(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Creeper', 'minecraft:creeper'], LegacyIds::CREEPER);

		$this->register(Cow::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Cow(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Cow', 'minecraft:cow'], LegacyIds::COW);

	    $this->register(Chicken::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Chicken(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Chicken', 'minecraft:chicken'], LegacyIds::CHICKEN);

	    $this->register(CaveSpider::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new CaveSpider(Helper::parseLocation($nbt, $world), $nbt);
		}, ['CaveSpider', 'minecraft:cavespider'], LegacyIds::CAVE_SPIDER);

	    $this->register(Cat::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Cat(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Cat', 'minecraft:cat'], LegacyIds::CAT);

	    $this->register(Blaze::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Blaze(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Blaze', 'minecraft:blaze'], LegacyIds::BLAZE);

	    #$this->register(Bee::class, function(World $world, CompoundTag $nbt) : MobsEntity{
		#	return new Bee(Helper::parseLocation($nbt, $world), $nbt);
		#}, ['Bee', 'minecraft:bee'], LegacyIds::BEE);

	    $this->register(Bat::class, function(World $world, CompoundTag $nbt) : MobsEntity{
			return new Bat(Helper::parseLocation($nbt, $world), $nbt);
		}, ['Bat', 'minecraft:bat'], LegacyIds::BAT);

	   # $this->register(Axolotl::class, function(World $world, CompoundTag $nbt) : MobsEntity{
		#	return new Axolotl(Helper::parseLocation($nbt, $world), $nbt);
		#}, ['Axolotl', 'minecraft:axolotl'], LegacyIds::AXOLOTL);








		$this->register(Human::class, function(World $world, CompoundTag $nbt) : Human{
			return new Human(Helper::parseLocation($nbt, $world), Human::parseSkinNBT($nbt), $nbt);
		}, ['Human']);
	}

	/**
	 * @phpstan-param \Closure(World, CompoundTag) : Entity $creationFunc
	 */
	private static function validateCreationFunc(\Closure $creationFunc) : void{
		$sig = new CallbackType(
			new ReturnType(Entity::class),
			new ParameterType("world", World::class),
			new ParameterType("nbt", CompoundTag::class)
		);
		if(!$sig->isSatisfiedBy($creationFunc)){
			throw new \TypeError("Declaration of callable `" . CallbackType::createFromCallable($creationFunc) . "` must be compatible with `" . $sig . "`");
		}
	}

	/**
	 * Registers an entity type into the index.
	 *
	 * @param string   $className Class that extends Entity
	 * @param string[] $saveNames An array of save names which this entity might be saved under.
	 * @phpstan-param class-string<Entity> $className
	 * @phpstan-param list<string> $saveNames
	 * @phpstan-param \Closure(World $world, CompoundTag $nbt) : Entity $creationFunc
	 *
	 * NOTE: The first save name in the $saveNames array will be used when saving the entity to disk.
	 *
	 * @throws \InvalidArgumentException
	 */
	public function register(string $className, \Closure $creationFunc, array $saveNames, ?int $legacyMcpeSaveId = null) : void{
		if(count($saveNames) === 0){
			throw new \InvalidArgumentException("At least one save name must be provided");
		}
		Utils::testValidInstance($className, Entity::class);
		self::validateCreationFunc($creationFunc);

		foreach($saveNames as $name){
			$this->creationFuncs[$name] = $creationFunc;
		}
		if($legacyMcpeSaveId !== null){
			$this->creationFuncs[$legacyMcpeSaveId] = $creationFunc;
		}

		$this->saveNames[$className] = reset($saveNames);
	}

	/**
	 * Creates an entity from data stored on a chunk.
	 *
	 * @throws SavedDataLoadingException
	 * @internal
	 */
	public function createFromData(World $world, CompoundTag $nbt) : ?Entity{
		try{
			$saveId = $nbt->getTag("id") ?? $nbt->getTag("identifier");
			$func = null;
			if($saveId instanceof StringTag){
				$func = $this->creationFuncs[$saveId->getValue()] ?? null;
			}elseif($saveId instanceof IntTag){ //legacy MCPE format
				$func = $this->creationFuncs[$saveId->getValue() & 0xff] ?? null;
			}
			if($func === null){
				return null;
			}
			/** @var Entity $entity */
			$entity = $func($world, $nbt);

			return $entity;
		}catch(NbtException $e){
			throw new SavedDataLoadingException($e->getMessage(), 0, $e);
		}
	}

	public function injectSaveId(string $class, CompoundTag $saveData) : void{
		if(isset($this->saveNames[$class])){
			$saveData->setTag("id", new StringTag($this->saveNames[$class]));
		}else{
			throw new \InvalidArgumentException("Entity $class is not registered");
		}
	}

	/**
	 * @phpstan-param class-string<Entity> $class
	 */
	public function getSaveId(string $class) : string{
		if(isset($this->saveNames[$class])){
			return $this->saveNames[$class];
		}
		throw new \InvalidArgumentException("Entity $class is not registered");
	}
}
