<?php

declare(strict_types=1);

namespace AutoClearLagg;

use pocketmine\scheduler\PluginTask;

class ClearLaggTask extends PluginTask {

	private $plugin;

	public function __construct(Main $main){
		$this->main = $main;
		parent::__construct($main);
	}

	public function onRun(int $currentTick) {
          $settings = $this->main->settings;
		if($settings->get("items") == true and $settings->get("mobs") == true) {
              $this->main->clearItems();
              $this->main->clearMobs();
              $this->main->getServer()->broadcastMessage($settings->get("all-cleared-message"));
          }
		if($settings->get("items") == true and $settings->get("mobs") == false) {
              $this->main->clearItems();
              $this->main->getServer()->broadcastMessage($settings->get("items-cleared-message"));
          }
		if($settings->get("mobs") == true and $settings->get("items") == false) {
              $this->main->clearMobs();
              $this->main->getServer()->broadcastMessage($settings->get("mobs-cleared-message"));
          }
	}
}

