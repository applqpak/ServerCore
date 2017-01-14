<?php

  namespace ServerCore\commands;
  
  use pocketmine\Player;
  use pocketmine\math\Vector3;
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\defaults\VanillaCommand;
  
  use ServerCore\Main;
  
  class TeleportCommand extends VanillaCommand
  {
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          parent::__construct(
              'teleport',
              'Teleport a player to you, or you to them',
              '/teleport <player> <player>'
          );
          $this->setAliases(['tp']);
          $this->setPermission('teleport.command');
          $this->plugin = $plugin;
      }
      
      public function execute(CommandSender $sender, $label, array $args)
      {
          if(!($this->testPermission($sender))) return false;
          if(count($args) < 2)
          {
              $sender->sendMessage(TF::RED . 'Usage: /teleport <player> <player>');
              return false;
          }
          if(is_string($args[0]))
          {
              $name   = array_shift($args);
              $player = $this->plugin->getServer()->getPlayer($name);
              if((!($player instanceof Player)) && ($name !== '@a'))
              {
                  $sender->sendMessage(TF::RED . $name . ' is not online.');
                  return false;
              }
              $name2   = array_shift($args);
              $player2 = $this->plugin->getServer()->getPlayer($name2);
              if(!($player2 instanceof Player))
              {
                  $sender->sendMessage(TF::RED . $name2 . ' is not online.');
                  return false;
              }
              if($name === '@a')
              {
                  foreach($this->plugin->getServer()->getOnlinePlayers() as $p)
                  {
                      $p->teleport($player);
                  }
                  $sender->sendMessage(TF::GREEN . 'Successfully teleport everyone to ' . $player->getName());
                  return true;
              }
              else
              {
                  $player->teleport($player2);
                  $sender->sendMessage(TF::GREEN . 'Successfully teleport ' . $player->getName() . ' to ' . $player2->getName());
                  return true;
              }
          }
          return true;
      }
  }
