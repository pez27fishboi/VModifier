<?php

/*
 * VModifier - A PocketMine-MP plugin to change what is displayed to the player when /version is issued
 * Copyright (C) 2017 Kevin Andrews <https://github.com/kenygamer/VModifier>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
*/

declare(strict_types=1);

namespace VModifier;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\plugin\PluginBase;

class VModifier extends PluginBase implements Listener{
    /** @var string[] */
    private $message;
    
    public function onEnable() : void{
        if(!is_dir($this->getDataFolder())){
            @mkdir($this->getDataFolder());
        }
        if(!file_exists($this->getDataFolder() . "config.yml")){
            $this->saveDefaultConfig();
        }
        $this->message = (array)$this->getConfig()->get("message", []);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    /**
     * @param PlayerCommandPreprocessEvent $event
     */
    public function onPlayerCommandPreprocess(PlayerCommandPreprocessEvent $event) : void{
        $player = $event->getPlayer();
        $command = strtolower(explode(" ", $event->getMessage())[0]);
        $commands = [
            "about",
            "ver",
            "version"
            ];
        if($command === "/about" or
           $command === "/ver" or
           $command === "/version" or
           $command === "/pocketmine:about" or
           $command === "/pocketmine:ver" or
           $command === "/pocketmine:version"){
            foreach($this->message as $line){
                $player->sendMessage($line);
            }
            $event->setCancelled(true);
        }
    }
    
}
