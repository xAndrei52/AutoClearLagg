<?php

/*
 *
 *   _____      _        _          _______ _          _____
 *  |  __ \    | |      | |        |__   __| |        |  __ \
 *  | |__) |__ | |_ __ _| |_ ___   ___| |  | |__   ___| |  | | _____   __
 *  |  ___/ _ \| __/ _` | __/ _ \ / _ \ |  | '_ \ / _ \ |  | |/ _ \ \ / /
 *  | |  | (_) | |_ (_| | |_ (_) |  __/ |  | | | |  __/ |__| |  __/\ V /
 *  |_|   \___/ \__\__,_|\__\___/ \___|_|  |_| |_|\___|_____/ \___| \_/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Potatoe
 * @link https://twitter.com/ImThePotatoe
 *
 *
*/

declare(strict_types=1);

namespace AutoClearLagg;

use pocketmine\entity\Creature;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{

    /** @var Config $settings */
    public $settings;

    public function onEnable() : void{
        $this->getLogger()->info("AutoClearLagg Enabled! Plugin by Potatoe. Download at https://github.com/PotatoeTrainYT/AutoClearLagg/");
        @mkdir($this->getDataFolder());
        $this->saveResource("settings.yml");
        $this->settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        if(is_numeric($this->settings->get("seconds"))){
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new ClearLaggTask($this), $this->settings->get("seconds") * 20);
        }else{
            $this->getLogger()->error(TextFormat::RED . "Plugin Disabled! Please enter a number for the seconds");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }

    public function clearItems() : int{
        $i = 0;
        foreach($this->getServer()->getLevels() as $level){
            foreach($level->getEntities() as $entity){
                if(!$this->isEntityExempted($entity) && !($entity instanceof Creature)){
                    $entity->close();
                    $i++;
                }
            }
        }
        return $i;
    }

    public function clearMobs() : int{
        $i = 0;
        foreach($this->getServer()->getLevels() as $level){
            foreach($level->getEntities() as $entity){
                if(!$this->isEntityExempted($entity) && $entity instanceof Creature && !($entity instanceof Human)){
                    $entity->close();
                    $i++;
                }
            }
        }
        return $i;
    }

    public function exemptEntity(Entity $entity) : void{
        $this->exemptedEntities[$entity->getID()] = $entity;
    }

    public function isEntityExempted(Entity $entity) : bool{
        return isset($this->exemptedEntities[$entity->getID()]);
    }
}