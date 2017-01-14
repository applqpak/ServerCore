<?php

  namespace ServerCore\commands;
  
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\defaults\VanillaCommand;
  
  use ServerCore\Main;
  
  class HelpCommand extends VanillaCommand
  {
      private $cfg;
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          parent::__construct(
              'help',
              'Display pages of help.',
              '/help <page>'
          );
          $this->setAliases(['h', '?']);
          $this->setPermission('help.command');
          $this->cfg    = $plugin->help;
          $this->plugin = $plugin;
      }
      
      public function execute(CommandSender $sender, $label, array $args)
      {
          if(!($this->testPermission($sender))) return false;
          if(count($args) < 1)
          {
              $sender->sendMessage(TF::RED . 'Usage: /help <page>');
              return false;
          }
          $page  = strtolower(array_shift($args));
          $pages = $this->cfg->get('pages');
          if(($page > 0) && ($page < $pages + 1))
          {
              $messages = $this->cfg->get('page.' . $page);
              foreach($messages as $message)
              {
                  $sender->sendMessage($message);
              }
          }
          else
          {
              if(($page > $pages) || ($page < 1))
              {
                  $messages = $this->cfg->get('page.1');
                  foreach($messages as $message)
                  {
                      $sender->sendMessage($message);
                  }
              }
          }
          return true;
      }
  }
