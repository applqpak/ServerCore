<?php

  namespace ServerCore\events;
  
  use pocketmine\event\Listener;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\event\player\PlayerQuitEvent;
  
  use ServerCore\Main;
  
  class onPlayerLeaveEvent implements Listener
  {
      private $cfg;
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          $this->cfg    = $plugin->join_leave;
          $this->plugin = $plugin;
      }
      
      public function onPlayerQuit(PlayerQuitEvent $event)
      {
          $name = $event->getPlayer()->getName();
          $quit = str_ireplace(['%player%', '#player#', '{player}'], [$name, $name, $name], $this->cfg->get('leave'));
          $event->setQuitMessage($quit);
      }
  }
