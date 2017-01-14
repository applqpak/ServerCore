<?php

  namespace ServerCore;
  
  use pocketmine\Player;
  use pocketmine\item\NBT;
  use pocketmine\item\Item;
  use pocketmine\command\Command;
  use pocketmine\nbt\tag\CompoundTag;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\defaults\VanillaCommand;
  
  use ServerCore\Main;
  
  class GiveCommand extends VanillaCommand
  {
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          parent::__construct(
              'give',
              'Give a player an item.',
              '/give <player> <item> <count>'
          );
          $this->setAliases(['g']);
          $this->setPermission('give.command');
          $this->plugin = $plugin;
      }
      
      public function execute(CommandSender $sender, $label, array $args)
      {
          if(!($this->testPermission($sender))) return false;
          if(count($args) < 3)
          {
              $sender->sendMessage(TF::RED . 'Usage: /give <player> <item> <count>');
              return false;
          }
          $name   = array_shift($args);
          $item   = Item::fromString(array_shift($args));
          $count  = array_shift($args);
          $item->setCount($count);
          $player = $this->plugin->getServer()->getPlayer($name);
          if(!($player instanceof Player))
          {
              $sender->sendMessage(TF::RED . $name . ' is not online.');
              return false;
          }
          $player->getInventory()->addItem(clone $item);
          $sender->sendMessage(TF::GREEN . 'Gave ' . $player->getName() . ' ' . $count . ' ' . $item);
          return true;
      }
  }
