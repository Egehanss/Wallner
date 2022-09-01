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

use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;
use pocketmine\VersionInfo;
use function count;
use function function_exists;
use function implode;
use function opcache_get_status;
use function sprintf;
use function stripos;
use function strtolower;
use const PHP_VERSION;

class VersionCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			KnownTranslationFactory::pocketmine_command_version_description(),
			KnownTranslationFactory::pocketmine_command_version_usage(),
			["versiyon", "surum"]
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_VERSION);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
          if (isset($args)){
		if(count($args) === 0){
			$sender->sendMessage("§f--- §cWallner Software§c v1.0.0 §f---");
			$sender->sendMessage("§c* §fNuclear Wallner Powered!");
			$sender->sendMessage("§c* §fDesteklenen Minecraft Bedrock Edition Sürümleri:§c 1.19.21§f, §c1.19.20");
			$sender->sendMessage("§c* §fişletim sistemi: §c".Utils::getOS()."");
			$sender->sendMessage("§c* §fProject Started By §cFurkanYks");
			$sender->sendMessage("§f--- §cWallner Software§c v1.0.0 §f---");

			if(
				function_exists('opcache_get_status') &&
				($opcacheStatus = opcache_get_status(false)) !== false &&
				isset($opcacheStatus["jit"]["on"])
			){
				$jit = $opcacheStatus["jit"];
				if($jit["on"] === true){
					$jitStatus = KnownTranslationFactory::pocketmine_command_version_phpJitEnabled(
						sprintf("CRTO: %s%s%s%s", $jit["opt_flags"] >> 2, $jit["opt_flags"] & 0x03, $jit["kind"], $jit["opt_level"])
					);
				}else{
					$jitStatus = KnownTranslationFactory::pocketmine_command_version_phpJitDisabled();
				}
			}else{
				$jitStatus = KnownTranslationFactory::pocketmine_command_version_phpJitNotSupported();
			}
			#$sender->sendMessage(KnownTranslationFactory::pocketmine_command_version_phpJitStatus($jitStatus));
			#$sender->sendMessage(KnownTranslationFactory::pocketmine_command_version_operatingSystem(Utils::getOS()));
		}else{
			
		}

		return true;
	}
}

	
}
