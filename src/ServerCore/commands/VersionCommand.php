<?php

  namespace ServerCore\commands;
  
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\defaults\VanillaCommand;
  
  use ServerCore\Main;
  
  class VersionCommand extends VanillaCommand
  {
      private $cfg;
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          parent::__construct(
              'version',
              'Get the server (software) version.',
              '/version'
          );
          $this->setAliases(['v']);
          $this->setPermission('version.command');
          $this->cfg    = $plugin->version;
          $this->plugin = $plugin;
      }
      
      public function execut(CommandSender $sender, $label, array $args)
      {
          if(!($this->testPermission($sender))) return false;
          $sender->sendMessage($this->cfg->get('version'));
          return true;
      }
  }
