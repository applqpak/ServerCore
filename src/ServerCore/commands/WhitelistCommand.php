<?php

  namespace ServerCore\commands;
  
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\defaults\VanillaCommand;
  
  use ServerCore\Main;
  
  class WhitelistCommand extends VanillaCommand
  {
      private $cfg;
      private $plugin;
      
      public function __construct(Main $plugin)
      {
          parent::__construct(
              'whitelist',
              'Allow only specific players to join.',
              '/whitelist <on | off | list | add[player] | remove[player] | reason[message]'
          );
          $this->setAliases(['wl']);
          $this->setPermission('whitelist.command');
          $this->cfg    = $plugin->whitelist;
          $this->plugin = $plugin;
      }
      
      public function execute(CommandSender $sender, $label, array $args)
      {
          if(!($this->testPermission($sender))) return false;
          if(count($args) < 1)
          {
              $sender->sendMessage(TF::RED . 'Usage: /whitelist <on | off | list | add[player] | remove[player] |reason[message]>');
              return false;
          }
          $arg = strtolower(array_shift($args));
          switch($arg)
          {
              case 'on':
                  if((bool)$this->cfg->get('whitelist') === true)
                  {
                      $sender->sendMessage(TF::RED . 'Whitelist is already on.');
                      return false;
                  }
                  $this->cfg->set('whitelist', true);
                  $this->cfg->save();
                  $sender->sendMessage(TF::GREEN . 'Whitelist is now on.');
                  return true;
              break;
              
              case 'off':
                  if((bool)$this->cfg->get('whitelist') === false)
                  {
                      $sender->sendMessage(TF::RED . 'Whitelist is already off.');
                      return false;
                  }
                  $this->cfg->set('whitelist', false);
                  $this->cfg->save();
                  $sender->sendMessage(TF::GREEN . 'Whitelist is now off.');
                  return true;
              break;
              
              case 'list':
                  $str     = '';
                  $players = $this->cfg->get('whitelisted_players');
                  foreach($players as $player)
                  {
                      if(end($players) === $player)
                      {
                          $str .= $player;
                      }
                      else
                      {
                          $str .= $player . ', ';
                      }
                  }
                  $sender->sendMessage(TF::GREEN . $str);
                  return true;
              break;
              
              case 'add':
                  if(count($args) < 1)
                  {
                      $sender->sendMessage(TF::RED . 'Usage: /whitelist add <player>');
                      return false;
                  }
                  $player    = strtolower(array_shift($args));
                  $players   = $this->cfg->get('whitelisted_players');
                  if(in_array($player, $players))
                  {
                      $sender->sendMessage(TF::RED . $player . ' is already whitelisted.');
                      return false;
                  }
                  $players[] = $player;
                  $this->cfg->set('whitelisted_players', $players);
                  $this->cfg->save();
                  $sender->sendMessage(TF::GREEN . 'Successfully added ' . $player . ' to the whitelist.');
                  return true;
              break;
              
              case 'remove':
                  if(count($args) < 1)
                  {
                      $sender->sendMessage(TF::RED . 'Usage: /whitelist remove <player>');
                      return false;
                  }
                  $player  = strtolower(array_shift($args));
                  $players = $this->cfg->get('whitelisted_players');
                  if(!(in_array($player, $players)))
                  {
                      $sender->sendMessage(TF::RED . $player . ' is not whitelisted.');
                      return false;
                  }
                  unset($players[array_search($player, $players)]);
                  $this->cfg->set('whitelisted_players', $players);
                  $this->cfg->save();
                  $sender->sendMessage(TF::GREEN . 'Successfully removed ' . $player . ' from the whitelist.');
                  return true;
              break;
              
              case 'reason':
                  if(count($args) < 1)
                  {
                      $sender->sendMessage(TF::RED . 'Usage: /whitelist reason <message>');
                      return false;
                  }
                  $reason = implode(' ', $args);
                  $this->cfg->set('whitelist_reason', $reason);
                  $this->cfg->save();
                  $sender->sendMessage(TF::GREEN . 'Succcessfully updated the Whitelist reason.');
                  return true;
              break;
              
              default:
                  $sender->sendMessage(TF::RED . 'Usage: /whitelist <on | off | list | add[player] | remove[player] | reason[message]>');
                  return false;
          }
          return true;
      }
  }
