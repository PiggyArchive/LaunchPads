<?php

namespace LaunchPads;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

class EventListener implements Listener{
    public function __construct($plugin){
        $this->plugin = $plugin;
    }

    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
        $block2 = $player->getLevel()->getBlock($player->floor()->subtract(0, 2));
        $launchpads = $this->plugin->getconfig()->get("launchpad");
        if(in_array($block->getId(), $launchpads)){
            if($this->plugin->getconfig()->get("enable-torch-mode")){
                if($block2->getId() == 50){
                    switch($block2->getDamage()){
                        case 2:
                            $player->knockBack($player, 0, -1, 0, 1);
                            return true;
                        case 1:
                            $player->knockBack($player, 0, 1, 0, 1);
                            return true;
                        case 4:
                            $player->knockBack($player, 0, 0, -1, 1);
                            return true;
                        case 3:
                            $player->knockBack($player, 0, 0, 1, 1);
                            return true;
                    }
                }   
            }
            switch($player->getDirection()){
                case 0:
                    $player->knockBack($player, 0, 1, 0, 1);
                    return true;
                case 1:
                    $player->knockBack($player, 0, 0, 1, 1);
                    return true;
                case 2:
                    $player->knockBack($player, 0, -1, 0, 1);
                    return true;
                case 3:
                    $player->knockBack($player, 0, 0, -1, 1);
                    return true;
            }    
        }
    }
}
