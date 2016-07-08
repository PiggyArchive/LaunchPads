<?php

namespace LaunchPads;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase{
    public function onEnable(){
        //@mkdir($this->getDataFolder());
        /*$this->launchpads = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
            "launchpad" => 152,
            "enable-torch-mode" => true
        ));
        */
		$this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getLogger()->info("§aEnabled.");
    }

}
