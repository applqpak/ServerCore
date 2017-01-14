<?php

  namespace ServerCore\events;
  
  use pocketmine\event\Listener;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\event\player\PlayerPreLoginEvent;
  
  use ServerCore\Main;
  
  class onPlayerPreLoginEvent implements Listener
  {
      private $cfg;
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          $this->cfg    = $plugin->welcome;
          $this->plugin = $plugin;
      }
      
      public function onPlayerPreLogin(PlayerPreLoginEvent $event)
      {
          $name      = strtolower($event->getPlayer()->getName());
          $reason    = $this->cfg->get('whitelist_reason');
          $players   = $this->cfg->get('whitelisted_players');
          $whitelist = (bool)$this->cfg->get('whitelist');
          if($whitelist === true)
          {
              if(!(in_array($name, $players)))
              {
                  $player->kick($reason, false);
                  $event->setCancelled(true);
              }
          }
      }
  }
