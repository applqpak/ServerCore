<?php

  namespace ServerCore\commands;
  
  use pocketmine\Player;
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\defaults\VanillaCommand;
  
  use ServerCore\Main;
  
  class KickCommand extends VanillaCommand
  {
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          parent::__construct(
              'kick',
              'Kick players from the server.',
              '/kick <player> [admin] [reason]'
          );
          $this->setAliases(['k']);
          $this->setPermission('kick.command');
          $this->plugin = $plugin;
      }
      
      public function execute(CommandSender $sender, $label, array $args)
      {
          if(!($this->testPermission($sender))) return false;
          if(count($args) < 2)
          {
              $sender->sendMessage(TF::RED . 'Usage: /kick <player> [admin] [reason]');
              return false;
          }
          $name   = array_shift($args);
          $player = $this->plugin->getServer()->getPlayer($name);
          if((!($player instanceof Player)) && ($name !== '@a'))
          {
              $sender->sendMessage(TF::RED . $name . ' is not online.');
              return false;
          }
          if(count($args) >= 2)
          {
              $admin  = array_shift($args);
              $reason = implode(' ', $args);
              if($name === '@a')
              {
                  foreach($this->plugin->getServer()->getOnlinePlayers() as $p)
                  {
                      $p->kick($reason, $admin);
                  }
                  $sender->sendMessage(TF::GREEN . 'Successfully kicked all players.');
                  return true;
              }
              $player->kick($reason, $admin);
              $sender->sendMessage(TF::GREEN . 'Successfully kicked ' . $player->getName());
              return true;
          }
          $player->kick('You were kicked from the server.', $admin);
          $sender->sendMessage(TF::GREEN . 'Successfully kicked ' . $player->getName());
          return true;
      }
  }
