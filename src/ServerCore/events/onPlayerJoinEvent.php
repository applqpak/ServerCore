<?php

  namespace ServerCore\events;
  
  use pocketmine\event\Listener;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\event\player\PlayerJoinEvent;
  
  use ServerCore\Main;
  
  class onPlayerJoinEvent implements Listener
  {
      private $cfg;
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          $this->cfg     = $plugin->join_leave;
          $this->plugin = $plugin;
      }
      
      public function onPlayerJoin(PlayerJoinEvent $event)
      {
          $name = $event->getPlayer()->getName();
          $join = str_ireplace(['%player%', '#player#', '{player}'], [$name, $name, $name], $this->cfg->get('join'));
          $event->setJoinMessage($join);
      }
  }
