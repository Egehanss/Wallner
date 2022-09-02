<?php


namespace pocketmine\wallner\block\tile;

use pocketmine\block\tile\TileFactory;

class Tiles
{
    public static function init() :void
    {
        $tf = TileFactory::getInstance();
        $tf->register(Campfire::class, ["Campfire", "minecraft:campfire"]);
        $tf->register(Lodestone::class, ["Lodestone", "minecraft:lodestone"]);

    }
}

