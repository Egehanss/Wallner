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

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function count; 

class GamemodeCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			KnownTranslationFactory::pocketmine_command_gamemode_description(),
			KnownTranslationFactory::commands_gamemode_usage()
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_GAMEMODE);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			throw new InvalidCommandSyntaxException();
		}

		$gameMode = GameMode::fromString($args[0]);
		if($gameMode === null){
			$sender->sendMessage(KnownTranslationFactory::pocketmine_command_gamemode_unknown($args[0]));
			return true;
		}

		if(isset($args[1])){
			$target = $sender->getServer()->getPlayerByPrefix($args[1]);
			if($target === null){
				$sender->sendMessage(KnownTranslationFactory::commands_generic_player_notFound()->prefix(TextFormat::RED));

				return true;
			}
		}elseif($sender instanceof Player){
			$target = $sender;
		}else{
			throw new InvalidCommandSyntaxException();
		}

		if($sender->getServer()->isYetkili($sender->getName())){
			$oyuncuisim = $sender->getName();
			$targetname = $target->getName();
		$sender->getServer()->sendToDiscordKoruma("@here **{$oyuncuisim}** adl?? ki??inin yetkililer listesinde ??zel izni oldu??u i??in **/gamemode** komutunu kullanmas??na izin veriyorum. gamemode verdi??i ki??inin yetkililer dosyas??nda ismi yoksa bu i??lem ba??ar??s??z olur. gamemode vermeye ??al????t?????? ki??inin ismi: **{$targetname}**");
		if($target->getServer()->isYetkili($target->getName())){

		$target->setGamemode($gameMode);
	}else{
		$targetname = $target->getName();
      $target->getServer()->sendToDiscordKoruma("@here **{$targetname}** adl?? ki??inin **yetkililer** listesinde ??zel izni olmad?????? i??in eyleme izin vermiyorum.");
	}
	}else{

	}


		if(!$gameMode->equals($target->getGamemode())){
$korumamesaj = $sender->getServer()->getWallnerStringConfig("wallner-koruma-mesaj");
		$sender->sendMessage("{$korumamesaj}");
		}else{
			if($target === $sender){
				Command::broadcastCommandMessage($sender, KnownTranslationFactory::commands_gamemode_success_self($gameMode->getTranslatableName()));
			}else{
				$target->sendMessage(KnownTranslationFactory::gameMode_changed($gameMode->getTranslatableName()));
				Command::broadcastCommandMessage($sender, KnownTranslationFactory::commands_gamemode_success_other($gameMode->getTranslatableName(), $target->getName()));
			}
		}

		return true;
	}
}
