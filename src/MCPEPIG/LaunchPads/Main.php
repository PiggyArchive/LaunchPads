<?php

namespace MCPEPIG\LaunchPads;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
  public function onEnable(){
    @mkdir($this->getServer()->getDataPath() . "/plugins/LaunchPads/");
    $this->launchPads = (new Config($this->getDataFolder()."config.yml", Config::YAML, array(
      "launchpad" => 152,
      "nlaunchpad" => 129,
      "slaunchpad" => 56,
      "wlaunchpad" => 21,
      "elaunchpad" => 14
    )));
    $this->getLogger()->info("§aLaunchPads by MCPEPIG loaded.");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  public function onPlayerMove(PlayerMoveEvent $event){
    $player = $event->getPlayer();
    $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
    $launchpad = $this->launchPads->get("launchpad");
    $nlaunchpad = $this->launchPads->get("nlaunchpad");
    $slaunchpad = $this->launchPads->get("slaunchpad");
    $wlaunchpad = $this->launchPads->get("wlaunchpad");
    $elaunchpad = $this->launchPads->get("elaunchpad");
    if($block->getId() === $launchpad){
      if($player->getDirection() == 0){
        $player->knockBack($player, 0, 1, 0, 1);
      }
      elseif($player->getDirection() == 1){
        $player->knockBack($player, 0, 0, 1, 1);
      }
      elseif($player->getDirection() == 2){
        $player->knockBack($player, 0, -1, 0, 1);
      }
      elseif($player->getDirection() == 3){
        $player->knockBack($player, 0, 0, -1, 1);
      }    
    }
    elseif($block->getId() === $nlaunchpad){
      $player->knockBack($player, 0, -1, 0, 1);       
    }
    elseif($block->getId() === $slaunchpad){
      $player->knockBack($player, 0, 1, 0, 1);
    }
    elseif($block->getId() === $wlaunchpad){
      $player->knockBack($player, 0, 0, 1, 1);      
    }
    elseif($block->getId() === $elaunchpad){
      $player->knockBack($player, 0, 0, -1, 1);     
    }
  }
}
