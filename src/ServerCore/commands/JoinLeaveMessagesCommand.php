<?php

  namespace ServerCore\commands;
  
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\defaults\VanillaCommand;
  
  use ServerCore\Main;
  
  class JoinLeaveMessagesCommand extends VanillaCommand
  {
      private $cfg;
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          parent::__construct(
              'joinleavemessages',
              'Set the join/leave messages of the server.',
              '/jlm <join[message] | leave[message]>'
          );
          $this->setAliases(['j', 'l', 'jl', 'jlm']);
          $this->setPermission('joinleavemessages.command');
          $this->cfg    = $plugin->join_leave;
          $this->plugin = $plugin;
      }
      
      public function execute(CommandSender $sender, $label, array $args)
      {
          if(!($this->testPermission($sender))) return false;
          if(count($args) < 2)
          {
              $sender->sendMessage(TF::RED . 'Usage: /jlm <join[message] | leave[message]>');
              return false;
          }
          $arg = strtolower(array_shift($args));
          switch($arg)
          {
              case 'join':
                  if(count($args) < 1)
                  {
                      $sender->sendMessage(TF::RED . 'Usage: /jlm join <message>');
                      return false;
                  }
                  $join = implode(' ', $args);
                  $this->cfg->set('join', $join);
                  $this->cfg->save();
                  $sender->sendMessage(TF::GREEN . 'Successfully updated the join message.');
                  return true;
              break;
              
              case 'leave':
                  if(count($args) < 1)
                  {
                      $sender->sendMessage(TF::RED . 'Usage: /jlm leave <message>');
                      return false;
                  }
                  $leave = implode(' ', $args);
                  $this->cfg->set('leave', $leave);
                  $this->cfg->save();
                  $sender->sendMessage(TF::GREEN . 'Successfully updated the leave message.');
                  return true;
              break;
              
              default:
                  $sender->sendMessage(TF::RED . 'Usage: /jlm <join[message] | leave[message]>');
                  return false;
          }
      }
  }
