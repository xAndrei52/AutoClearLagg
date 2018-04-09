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

class ClearLaggTask extends PluginTask{

    /** @var */
    private $plugin;

    /**
     * ClearLaggTask constructor
     * #
     * @param Main $plugin
     */
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }

    /**
     * When the plugin runs
     *
     * @param int $currentTick
     */
    public function onRun(int $currentTick){
        $settings = $this->plugin->settings;
        if($settings->get("items") == true and $settings->get("mobs") == true){
            $this->plugin->clearItems();
            $this->plugin->clearMobs();
            $this->plugin->getServer()->broadcastMessage($settings->get("all-cleared-message"));
        }
        if($settings->get("items") == true and $settings->get("mobs") == false){
            $this->plugin->clearItems();
            $this->plugin->getServer()->broadcastMessage($settings->get("items-cleared-message"));
        }
        if($settings->get("mobs") == true and $settings->get("items") == false){
            $this->plugin->clearMobs();
            $this->plugin->getServer()->broadcastMessage($settings->get("mobs-cleared-message"));
        }
    }
}

