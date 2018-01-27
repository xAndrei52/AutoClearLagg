<?php

declare(strict_types=1);

namespace AutoClearLagg;

use pocketmine\entity\Creature;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

class Main extends PluginBase {

    public function onEnable() : void {
        $this->getLogger()->info("AutoClearLagg Enabled! Plugin by Potatoe. Download at https://github.com/PotatoeTrainYT/AutoClearLagg/");
        @mkdir($this->getDataFolder());
        $this->saveResource("settings.yml");
        $this->settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $this->scheduler();
    }

    public function scheduler() {
        if(is_numeric($this->settings->get("seconds"))) {
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new ClearLaggTask($this), $this->settings->get("seconds") * 20);
        } else {
            $this->getLogger()->warning("Plugin disabling, Seconds is not a numeric value please edit");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }

    public function clearItems() : int {
        $i = 0;
        foreach($this->getServer()->getLevels() as $level) {
            foreach($level->getEntities() as $entity) {
                if(!$this->isEntityExempted($entity) && !($entity instanceof Creature)) {
                    $entity->close();
                    $i++;	
                }
            }		
        }	
        return $i;
    }

    public function clearMobs() : int {
        $i = 0;
        foreach($this->getServer()->getLevels() as $level) {
            foreach($level->getEntities() as $entity) {
                if(!$this->isEntityExempted($entity) && $entity instanceof Creature && !($entity instanceof Human)) {
                    $entity->close();
                    $i++;	
                }
            }		
        }	
        return $i;
    }

    public function exemptEntity(Entity $entity) : void {
        $this->exemptedEntities[$entity->getID()] = $entity;
    }

    public function isEntityExempted(Entity $entity) : bool {
        return isset($this->exemptedEntities[$entity->getID()]);
    }
}
