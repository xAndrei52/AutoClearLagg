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

class Main extends PluginBase{

    /** @var */
    public $settings;

    /**
     * When the plugin enables
     *
     * @return void
     */
    public function onEnable() : void{
        $this->getLogger()->info("AutoClearLagg Enabled! Plugin by Potatoe. Download at https://github.com/PotatoeTrainYT/AutoClearLagg/");
        @mkdir($this->getDataFolder());
        $this->saveResource("settings.yml");
        $this->settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $this->scheduler();
    }

    /**
     * Schedule tasks
     *
     * @return bool
     */
    public function scheduler() : bool{
        $seconds = $this->settings->get("seconds");
        if(is_numeric($seconds)){
            if($seconds >= 60){
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new TimerTask($this, 60), $seconds * 20 - 1200);
            }
            if($seconds >= 30){
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new TimerTask($this, 30), $seconds * 20 - 600);
            }
            if($seconds >= 10){
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new TimerTask($this, 10), $seconds * 20 - 200);
            }
            if($seconds >= 5){
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new TimerTask($this, 5), $seconds * 20 - 100);
            }
            if($seconds >= 4){
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new TimerTask($this, 4), $seconds * 20 - 80);
            }
            if($seconds >= 3){
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new TimerTask($this, 3), $seconds * 20 - 60);
            }
            if($seconds >= 2){
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new TimerTask($this, 2), $seconds * 20 - 40);
            }
            if($seconds >= 1){
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new TimerTask($this, 1), $seconds * 20 - 20);
            }
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new ClearLaggTask($this), $seconds * 20);
            return true;
        }else{
            $this->getLogger()->warning("Plugin disabling, Seconds is not a numeric value please edit");
            $this->getPluginLoader()->disablePlugin($this);
            return false;
        }
    }

    /**
     * Clear all items
     *
     * @return int
     */
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

    /**
     * Clear all entites
     *
     * @return int
     */
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

    /**
     * Exempts entites
     *
     * @param Entity $entity
     *
     * @return void
     */
    public function exemptEntity(Entity $entity) : void{
        $this->exemptedEntities[$entity->getID()] = $entity;
    }

    /**
     * Checks if entity is exempted
     *
     * @param Entity $entity
     *
     * @return bool
     */
    public function isEntityExempted(Entity $entity) : bool{
        return isset($this->exemptedEntities[$entity->getID()]);
    }
}
