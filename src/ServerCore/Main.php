<?pphp

  namespace ServerCore;
  
  use pocketmine\plugin\PluginBase;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\utils\Config;
  
  use ServerCore\events\onPlayerJoinEvent;
  use ServerCore\events\onPlayerLeaveEvent;
  use ServerCore\events\onPlayerPreLoginEvent
  
  use ServerCore\commands\HelpCommand;
  use ServerCore\commands\GiveCommmand;
  use ServerCore\commands\KickCommand;
  use ServerCore\commands\VersionCommand;
  use ServerCore\commands\PluginsCommand;
  use ServerCore\commands\TeleportCommand;
  use ServerCore\commands\WhitelistCommand;
  use ServerCore\commands\JoinLeaveMessagesCommand;
  
  class Main extends PluginBase;
  {
      public $help;
      public $version;
      public $plugins;
      public $whitelist;
      public $join_leave;
      
      public $events   = [onPlayerJoinEvent::class, onPlayerLeaveEvent::class, onPlayerPreLoginEvent::class];
      
      public $commands = ['help',  'give', 'kick', 'version', 'plugins', 'teleport', 'whitelist'];
      
      public function onEnable()
      {
         /*###########
          *# configs #
          *###########
          */
          @mkdir($this->getDataFolder());
          $this->saveResource('help.yml');
          $this->saveResource('version.yml');
          $this->saveResource('plugins.yml');
          $this->saveResource('whitelist.yml');
          $this->saveResource('join_leave.yml');
          $this->help       = new Config($this->getDataFolder() . 'help.yml', Config::YAML);
          $this->version    = new Config($this->getDataFolder() . 'version.yml', Config::YAML);
          $this->plugins    = new Config($this->getDataFolder() . 'plugins.yml', Config::YAML);
          $this->whitelist  = new Config($this->getDataFolder() . 'whitelist.yml', Config::YAML);
          $this->join_leave = new Config($this->getDatFolder() . 'join_leave.yml', Config::YAML;
          
         /*##########
          *# events #
          *##########
          */
          foreach($this->events as $event)
          {
              $this->getServer()->getPluginManager()->registerEvents(new $event($this), $this);
          }
          
         /*############
          *# commands #
          *############
          */
          foreach($this->commands as $command)
          {
              if($this->getServer()->getCommandMap()->getCommand($command) !== null)
              {
                  $this->getServer()->getCommandMap()->getCommand($command)->setLabel($command . '__');
                  $this->getServer()->getCommandMap()->getCommand($command)->unregister($this->getServer()->getCommandMap());
              }
          }
          $this->getServer()->getCommandMap()->register('help', new HelpCommand($this));
          $this->getServer()->getCommandMap()->register('give', new GiveCommand($this));
          $this->getServer()->getCommandMap()->register('kick', new KickCommand($this));
          $this->getServer()->getCommandMap()->register('version', new VersionCommand($this));
          $this->getServer()->getCommandMap()->register('plugins', new PluginsCommand($this));
          $this->getServer()->getCommandMap()->register('welcome', new WelcomeCommand($this));
          $this->getServer()->getCommandMap()->register('teleport', new TeleportCommand($this));
          $this->getServer()->getCommandMap()->register('whitelist', new WhitelistCommand($this));
          $this->getServer()->getCommandMap()->register('joinleavemessages', new JoinLeaveMessagesCommmand($this));
          $this->getLogger()->info(TF::GREEN . 'Enabled.');
      }
      
      public function onDisable()
      {
          $this->getLogger()->info(TF::RED . 'Disabled.');
      }
  }
