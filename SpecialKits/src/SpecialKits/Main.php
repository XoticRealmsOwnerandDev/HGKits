<?php

namespace SpecialKits;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\entity\Effect;
use pocketmine\item\Item;

use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\math\Vector3;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\utils\Config;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\entity\Entity;
use pocketmine\utils\Random;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\protocol\UseItemPacket;

use pocketmine\utils\TextFormat as color;

class Main extends PluginBase implements Listener{
     public function onEnable(){
         
        $this->fisherman = new Config($this->getDataFolder() . "fishermanConfig.yml" , Config::YAML, Array(
            "KnockBack-Power" => 0.6,
            "FishermanKit_Item" => 346,
            "FishermanKit_receive" => "§bVocê pegou Kit Fisherman",
            "KnockBack_KitLauncher-Power" => 1.3,
            "LauncherKit_Item" => 352,
            "LauncherKit_receive" => "§bVocê pegou Kit Launcher",
        ));
        $this->saveResource("fishermanConfig.yml");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
         
	$this->getServer()->getLogger()->info(color::YELLOW. "HGKITS-SpecialKits Ligado!");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
	
	$yml = new Config($this->getDataFolder() . "config.yml", Config::YAML, Array(
		"ID" => 288,
		"Decide" => "Popup",
		"Message" => "§a§lKangaruu",
		"ItemName" => "§b§l§oKangaruu",
		"Choose" => "Popup",
		"CoolDownMsg" => "§cEspere Por Favor!",
	));
    $this->yml = $yml->getAll();
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
	$this->saveResource("config.yml");
        
    $this->config = new Config($this->getDataFolder() . "kitconfig.yml" , Config::YAML, Array(
        "endermageKit_receive" => "§bVocê pegou Kit Endermage",
        "stomperKit_receive" => "§bNao funcioanr",
        "kangaruuKit_receive" => "§eVocê pegou kit Kangaruu",
        "urgalKit_receive" => "§cVocê pegou Kit Urgal",
        "urgalKit_Time" => 10000,
        "urgalKit_Item" => 366,
	"minerKit_receive" => "§bVocê pegou Kit Miner",
        "minerKit_Item" => 278,
	"minerKit_Speed_Level" => 1,
	"minerKit_Speed_Duration" => 10000,
        "lifekit_receive" => "§cVoce pegou o kit LifeKit",
	"lifeKit_Regen_level" => 1,
        "lifeKit_Item" => 265,
        "suicideKit_receive" => "§cVocê pegou o kit suicide",
	"suicideKit_Item" => 265,
     ));
    $this->saveResource("kitconfig.yml");
    
    $this->kitsConfig = new Config($this->getDataFolder() . "kitmessage.yml" , Config::YAML, Array(
        "kitsTitle_Title" => "§a-- §bKITS §a--",
        "kitsMessage_1" => "§a/endermage §bKit EnderMage",
        "kitsMessage_2" => "§a/kangaruu §bKit Kangaruu",
        "kitsMessage_3" => "§a/stomper §bKit Stomper",
        "kitsMessage_4" => "§a/urgal §bKit Urgal",
        "kitsMessage_5" => "§a/switcher §bKit Switcher",
        "kitsMessage_6" => "§a/suicide §bKit Suicide",
        "kitsMessage_7" => "§a/life §bKit Life",
        "kitsMessage_8" => "§a/miner §bKit Miner",
        "kitsMessage_9" => "§a/fisherman §bKit Fisherman",
        "kitsMessage_10" => "§a/launcher §bKit Launcher",
    ));
    $this->saveResource("kitmessage.yml");
	
    
  }
     public function onCommand(CommandSender $sender, Command $command, $label, array $args){
          switch($command->getName()){
         case "kits":
             $kitsTitle = $this->kitsConfig->get("kitsTitle_Title");
             $kitsMessage1 = $this->kitsConfig->get("kitsMessage_1");
             $kitsMessage2 = $this->kitsConfig->get("kitsMessage_2");
             $kitsMessage3 = $this->kitsConfig->get("kitsMessage_3");
             $kitsMessage4 = $this->kitsConfig->get("kitsMessage_4");
             $kitsMessage5 = $this->kitsConfig->get("kitsMessage_5");
             $kitsMessage6 = $this->kitsConfig->get("kitsMessage_6");
             $kitsMessage7 = $this->kitsConfig->get("kitsMessage_7");
             $kitsMessage8 = $this->kitsConfig->get("kitsMessage_8");
             $kitsMessage9 = $this->kitsConfig->get("kitsMessage_9");
             $kitsMessage10 = $this->kitsConfig->get("kitsMessage_10");
             $sender->sendMessage($kitsTitle);
             $sender->sendMessage($kitsMessage1);
             $sender->sendMessage($kitsMessage2);
             $sender->sendMessage($kitsMessage3);
             $sender->sendMessage($kitsMessage4);
             $sender->sendMessage($kitsMessage5);
             $sender->sendMessage($kitsMessage6);
             $sender->sendMessage($kitsMessage7);
             $sender->sendMessage($kitsMessage8);
             $sender->sendMessage($kitsMessage9);
             $sender->sendMessage($kitsMessage10);
                return false;
         case "endermage":
             $endermageReceive = $this->config->get("endermageKit_receive");
             $sender->getInventory()->addItem(Item::get(90, 0, 1));
			 $sender->sendMessage($endermageReceive);
		return false;
         case "kangaruu":
             $kangaruuReceive = $this->config->get("kangaruuKit_receive");
             $sender->getInventory()->addItem(Item::get(288, 0, 1));
                $sender->sendMessage($kangaruuReceive);
                return false;
         case "life":
             $lifeReceive = $this->config->get("lifeKit_receive");
               $lifeLevel = $this->config->get("lifeKit_Regen_Level");
                
                $sender->addEffect(Effect::getEffect(10)->setAmplifier($lifeLevel)->setDuration(10000)->setVisible(false));
             $sender->getInventory()->addItem(Item::get(265, 0, 2));
                $sender->sendMessage($lifeReceive);
                return false;
         case "urgal":
			$urgalItem = $this->config->get("urgalKit_Item");
			$urgalReceive = $this->config->get("urgalKit_receive");
			$sender->getInventory()->addItem(Item::get($urgalItem, 0, 1));
			$sender->getInventory()->addItem(Item::get($urgalItem, 0, 1));
			$sender->getInventory()->addItem(Item::get($urgalItem, 0, 1));
             $sender->sendMessage($urgalReceive);
                return false;
		 case "miner":
                $minerReceive = $this->config->get("minerKit_receive");
                $minerItem = $this->config->get("minerKit_Item");
                $minerSpeedL = $this->config->get("minerKit_Speed_Level");
                $minerSpeedD = $this->config->get("minerKit_Speed_Duration");
                
                $sender->sendMessage($minerReceive);
                $sender->getInventory()->addItem(Item::get($minerItem));
                
                $sender->addEffect(Effect::getEffect(3)->setAmplifier($minerSpeedL)->setDuration($minerSpeedD)->setVisible(false));
                return false;
         case "suicide":
			$suicideItem = $this->config->get("suicideKit_Item");
 			$suicideReceive = $this->config->get("suicideKit_receive");      
			$sender->getInventory()->addItem(Item::get($suicideItem, 0, 1));
             $sender->sendMessage($suicideReceive);
                return false;
         case "fisherman":
             $fishermanItem2 = $this->fisherman->get("FishermanKit_Item");
             $fishermanReceive = $this->fisherman->get("FishermanKit_receive");
             $sender->sendMessage($fishermanReceive);
             $sender->getInventory()->addItem(Item::get($fishermanItem2));
             return false;
         case "launcher":
             $launcherItem2 = $this->fisherman->get("LauncherKit_Item");
             $launcherReceive = $this->fisherman->get("LauncherKit_receive");
             $sender->sendMessage($launcherReceive);
             $sender->getInventory()->addItem(Item::get($launcherItem2));
		  }
	 }
	 
	public function onTip(PlayerItemHeldEvent $ev){
		if($ev->getPlayer()->getInventory()->getItemInHand()->getId() === 90){
			$ev->getPlayer()->sendTip(color::YELLOW. "Endermage");
		}  if($ev->getPlayer()->getInventory()->getItemInHand()->getId() === 265){
			$ev->getPlayer()->sendTip(color::YELLOW. "LifeKit");
		}
	}
	            public function onPacketReceived(DataPacketReceiveEvent $event){
            $pk = $event->getPacket();
            $player = $event->getPlayer();
            if($pk instanceof UseItemPacket and $pk->face === 0xff) {
             $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
            $item = $player->getInventory()->getItemInHand();
            if($player->hasPermission("kangaruu.use.axe")){
            if( $block->getId() === 0){
if( $this->yml["Choose"] == "Popup"){
$player->sendTIP($this->yml["CoolDownMsg"]);
   }
   elseif($this->yml["Choose"] == "Message"){
   $player->sendMessage($this->yml["CoolDownMsg"]);
}      
      return true;
      }
            if($item->getId() == $this->yml["ID"] ){
      if($player->getDirection() == 0){
        $player->knockBack($player, 0, 1, 0, 1);
      }
      elseif($player->getDirection() == 1){
        $player->knockBack($player, 0, 0, 1, 1);
      }
      elseif($player->getDirection() == 2){
        $player->knockBack($player, 0, -1, 0, 1);
      }
      elseif($player->getDirection() == 3){
        $player->knockBack($player, 0, 0, -1, 1);
        }
      if( $this->yml["Decide"] == "Popup"){
$player->sendTIP($this->yml["Message"]);
   }
   elseif($this->yml["Decide"] == "Message"){
   $player->sendMessage($this->yml["Message"]);
}
}
}
}
}
	public function onPlayerItemHeldEvent(PlayerItemHeldEvent $e){
		$i = $e->getItem();
		$p = $e->getPlayer();
		if($i instanceof Item){
			switch ($i->getId()){
				case $this->getConfig()->get("ID"):
				$p->sendPopup($this->getConfig()->get("ItemName"));
				}
		}
}
public function onDamage(EntityDamageEvent $event){
if($event->getEntity() instanceof Player){
      if($event->getCause() == EntityDamageEvent::CAUSE_FALL){
$event->setCancelled();
}
}
   }
 public function onSneak(PlayerToggleSneakEvent $e){
 $player = $e->getPlayer();
 $level = $player->getLevel();
 $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
 $pos = new Vector3($player->getFloorX(), $player->getFloorY() - 2, $player->getFloorZ());
$pos2 = $level->getBlock($pos);
          if($player->hasPermission("kangaruu.use.crouch")){
          if($pos2->getId() === 0){
if( $this->yml["Choose"] == "Popup"){
$player->sendTIP($this->yml["CoolDownMsg"]);
   }
   elseif($this->yml["Choose"] == "Message"){
   $player->sendMessage($this->yml["CoolDownMsg"]);
   return true;
}
}
     if($block->getId() === 0){
     if($pos2->getId() !== 0){
     if($player->getDirection() == 0){
        $player->knockBack($player, 0, 1, 0, 1);
      }
      elseif($player->getDirection() == 1){
        $player->knockBack($player, 0, 0, 1, 1);
      }
      elseif($player->getDirection() == 2){
        $player->knockBack($player, 0, -1, 0, 1);
      }
      elseif($player->getDirection() == 3){
        $player->knockBack($player, 0, 0, -1, 1);
      }
      if( $this->yml["Decide"] == "Popup"){
$player->sendTIP($this->yml["Message"]);
   }
   elseif($this->yml["Decide"] == "Message"){
   $player->sendMessage($this->yml["Message"]);
   }
}
}
}
}

   public function onUse(PlayerInteractEvent $event) {
    $player = $event->getPlayer();
    if(count($player->getEffects()) != 3) {
      if($event->getItem()->getID() == 282) {
        $player->getInventory()->removeItem(Item::get(282, 0, 1));
        $player->getInventory()->addItem(Item::get(281, 0, 1));
		$player->setHealth(20);
      }

    }else{
      $player->sendMessage("");
    }   if($event->getItem()->getID() == $this->config->get("urgalKit_Item")) {
		$urgalItem = $this->config->get("urgalKit_Item");
		$urgalTime = $this->config->get("urgalKit_Time");
		  $player->getInventory()->removeItem(Item::get($urgalItem, 0, 1));
         $player->addEffect(Effect::getEffect(5)->setAmplifier(0)->setDuration($urgalTime)->setVisible(true));
		$player->setHealth(20);
  } if($event->getItem()->getID() == 265) {
      $lifeItem = $this->config->get("lifeKit_Item");
      $player->getInventory()->removeItem(Item::get($lifeItem, 0, 1));
		$player->setHealth(25);
                $player->getInventory()->removeItem(Item::get($lifeItem, 0, 1));
}
}

    public function onHurt(EntityDamageEvent $event){
		if($event instanceof EntityDamageByEntityEvent){
			$damager = $event->getDamager();
			if($damager instanceof Player){
                            $launcherItem =  $this->fisherman->get("LauncherKit_Item");
                            $fishermanItem = $this->fisherman->get("FishermanKit_Item");
				if($damager->getInventory()->getItemInHand()->getId() === $fishermanItem){
					$event->setKnockBack($this->fisherman->get("KnockBack-Power"));
				} if($damager->getInventory()->getItemInHand()->getId() === $launcherItem){
					$event->setKnockBack($this->fisherman->get("KnockBack_KitLauncher-Power")); 
                                }
			}
		}
	}
}

