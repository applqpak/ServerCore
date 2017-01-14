<?php

  namespace ServerCore\commands;
  
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\defaults\VanillaCommand;
  
  use ServerCore\Main;
  
  class PluginsCommand extends VanillaCommand
  {
      private $cfg;
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          parent::__construct(
              
          );
          $this->setAliases(['p']);
          $this->setPermission('plugins.command');
          $this->cfg    = $plugin->plugins;
          $this->plugin = $plugin;
      }
      
      public function execute(CommandSender $sender, $label, array $args)
      {
          if(!($this->testPermission($sender))) return false;
          $sender->sendMessage($this->cfg->get('plugins'));
          return true;
      }
  }
