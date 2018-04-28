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

use pocketmine\scheduler\PluginTask;

class TimerTask extends PluginTask{

    /** @var Main $plugin */
    private $plugin;
    /** @var int $seconds */
    private $seconds = 0;

    public function __construct(Main $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick) : void{
        $seconds = $this->plugin->settings->get("seconds");
        $time = $seconds * 20;
        $this->seconds++;
        $clearlaggTime = $time - $this->seconds;
        if(is_numeric($seconds)){
            switch($clearlaggTime){
                case 60:
                    $this->plugin->getServer()->broadcastMessage(str_replace("{SECONDS}", 60, $this->plugin->settings->get("time-left-message")));
                    break;
                case 30:
                    $this->plugin->getServer()->broadcastMessage(str_replace("{SECONDS}", 30, $this->plugin->settings->get("time-left-message")));
                    break;
                case 10:
                    $this->plugin->getServer()->broadcastMessage(str_replace("{SECONDS}", 10, $this->plugin->settings->get("time-left-message")));
                    break;
                case 5:
                    $this->plugin->getServer()->broadcastMessage(str_replace("{SECONDS}", 5, $this->plugin->settings->get("time-left-message")));
                    break;
                case 4:
                    $this->plugin->getServer()->broadcastMessage(str_replace("{SECONDS}", 4, $this->plugin->settings->get("time-left-message")));
                    break;
                case 3:
                    $this->plugin->getServer()->broadcastMessage(str_replace("{SECONDS}", 4, $this->plugin->settings->get("time-left-message")));
                    break;
                case 2:
                    $this->plugin->getServer()->broadcastMessage(str_replace("{SECONDS}", 4, $this->plugin->settings->get("time-left-message")));
                    break;
                case 1:
                    $this->plugin->getServer()->broadcastMessage(str_replace("{SECONDS}", 4, $this->plugin->settings->get("time-left-message")));
                    break;
                case 0:
                    $this->plugin->getServer()->getScheduler()->scheduleRepeatingTask(new ClearLaggTask($this->plugin), $seconds * 20);
                    break;
            }
        }else{
            $this->plugin->getLogger()->warning("Plugin disabling, Seconds is not a numeric value please edit");
            $this->plugin->getPluginLoader()->disablePlugin($this->plugin);
        }
    }
}