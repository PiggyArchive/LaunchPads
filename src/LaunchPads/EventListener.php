<?php
namespace LaunchPads;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\Listener;
use pocketmine\Player;

class EventListener implements Listener {
    public function __construct($plugin) {
        $this->plugin = $plugin;
    }

    public function onDamage(EntityDamageEvent $event) {
        $entity = $event->getEntity();
        $cause = $event->getCause();
        if($entity instanceof Player && $cause == 4) {
            if(isset($this->plugin->launchpad[strtolower($entity->getName())])) {
                unset($this->plugin->launchpad[strtolower($entity->getName())]);
                $event->setCancelled();
            }
        }
    }

    public function onMove(PlayerMoveEvent $event) {
        $player = $event->getPlayer();
        $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
        $block2 = $player->getLevel()->getBlock($player->floor()->subtract(0, 2));
        $launchpads = $this->plugin->getConfig()->get("launchpads");
        $strength = $this->plugin->getConfig()->get("launchpad-strength");
        if(in_array($block->getId(), $launchpads)) {
            $this->plugin->launchpad[strtolower($player->getName())] = true;
            if($this->plugin->getConfig()->get("enable-torch-mode")) {
                if($block2->getId() == 50) {
                    switch($block2->getDamage()) {
                        case 2:
                            $player->knockBack($player, 0, -1, 0, $strength);
                            return true;
                        case 1:
                            $player->knockBack($player, 0, 1, 0, $strength);
                            return true;
                        case 4:
                            $player->knockBack($player, 0, 0, -1, $strength);
                            return true;
                        case 3:
                            $player->knockBack($player, 0, 0, 1, $strength);
                            return true;
                    }
                }
            }
            switch($player->getDirection()) {
                case 0:
                    $player->knockBack($player, 0, 1, 0, $strength);
                    return true;
                case 1:
                    $player->knockBack($player, 0, 0, 1, $strength);
                    return true;
                case 2:
                    $player->knockBack($player, 0, -1, 0, $strength);
                    return true;
                case 3:
                    $player->knockBack($player, 0, 0, -1, $strength);
                    return true;
            }
        }
        if(isset($this->plugin->launchpad[strtolower($player->getName())])) {
            if(!$block->getId() == 0) {
                unset($this->plugin->launchpad[strtolower($player->getName())]);
            }
        }
    }
}
