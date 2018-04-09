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

    /** @var */
    private $plugin;
    /** @var int */
    private $seconds;

    /**
     * TimerTask constructor
     *
     * @param Main $plugin
     * @param int $seconds
     */
    public function __construct(Main $plugin, int $seconds){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->seconds = $seconds;
    }

    public function onRun(int $currentTick){
        // TODO: Implement Message or Popup Feature
        $this->plugin->getServer()->broadcastMessage(str_replace("{SECONDS}", $this->seconds, $this->plugin->settings->get("time-left-message")));
    }
}