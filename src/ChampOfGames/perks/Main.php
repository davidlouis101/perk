<?php

declare(strict_types=1);

namespace perks;

use pocketmine\block\BlockFactory;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\command\ConsoleCommandSender;

use pocketmine\entity\Entity;

use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\event\entity\EntityDamageEvent;

use pocketmine\event\entity\EntitySpawnEvent;

use pocketmine\event\Listener;

use pocketmine\Item\Item;

use pocketmine\event\player\PlayerQuitEvent;

use pocketmine\event\player\PlayerLoginEvent;

use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\nbt\tag\CompoundTag;

use pocketmine\nbt\tag\StringTag;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\TextFormat;

use pocketmine\entity\Effect;

use pocketmine\entity\EffectInstance;

use DateTime;

use jojoe77777\FormAPI;

use pocketmine\Server;

class Main extends PluginBase implements Listener {

    public $prefix = "§l§bPerks §c> ";

    /** @var string */

    public $noperm = TextFormat::AQUA . "[" . TextFormat::RED . "Perks" . TextFormat::AQUA . "] You don't have permission.";

    public $helpHeader =

        TextFormat::AQUA . "--- " .

        TextFormat::AQUA . "[" . TextFormat::RED . "Perks Hilfe" . TextFormat::AQUA . "] " .

        TextFormat::AQUA . "---";

    /**

     * @return void

     */

    public function checkDepends(){

        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

        if(is_null($this->formapi)){

            $this->getLogger()->info("§4Please install FormAPI Plugin, disabling plugin...");

            $this->getPluginLoader()->disablePlugin($this);

            }

        }

        

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {

        switch (strtolower($command->getName())) {

            case "perk":

                if ($sender instanceof Player) {

                    if (!isset($args[0])) {

                        if (!$sender->hasPermission("perks.command")) {

                            $sender->sendMessage($this->noperm);

                            return true;

                        } else {

                            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

        $form = $api->createSimpleForm(function (Player $sender, $data){

            $result = $data;

            if ($result == null) {

            }

            switch ($result) {

                    case 0:

                    $sender->addTitle("§bPerks", "§cby Crow Balde");

                        break;

                    case 1:

                    $command = "perks help";

								$this->getServer()->getCommandMap()->dispatch($sender, $command);						break;

						           case 2:

                    $command = "perks jump";

								$this->getServer()->getCommandMap()->dispatch($sender, $command);

                        break;

                                   case 3:

                    $command = "perks break";

								$this->getServer()->getCommandMap()->dispatch($sender, $command);

                        break;

                                   case 4:

                    $command = "perks atmung";

								$this->getServer()->getCommandMap()->dispatch($sender, $command);

                        break;

                                   case 5:

                    $command = "perks fire";

								$this->getServer()->getCommandMap()->dispatch($sender, $command);

                        break;

                                   case 6:

                    $command = "perks damage";

								$this->getServer()->getCommandMap()->dispatch($sender, $command);

                        break;

                                   case 7:

                    $command = "perks night";

								$this->getServer()->getCommandMap()->dispatch($sender, $command);

                        break;

             }

             });

        $form->setTitle("§l§bPerkSystem");

        $form->setContent("§6 PerkSystem Made By Crow Balde");

        $form->addButton("§4 Verlassen", 0);

        $form->addButton("§dHilfe", 1);

        $form->addButton("§dSpringe Höher", 2);

        $form->addButton("§dBlocke Schneller Abbauen", 3);

        $form->addButton("§dUnterwasser Atem ", 4);

        $form->addButton("§dKein Feuer Schaden", 5);

        $form->addButton("§dKein Damage", 6);

        $form->addButton("§dNachtsicht", 7);

        $form->sendToPlayer($sender);

        }

        return true;

                    }

                    $arg = array_shift($args);

                    switch ($arg) {

                        case "version":

                            if (!$sender->hasPermission("perks.version")) {

                                $sender->sendMessage($this->noperm);

                                return true;

                            }

                            $sender->sendMessage($this->prefix . "§r" . TextFormat::BLUE . "Perks Version 1.0.0 by Crow Balde");

                            return true;

                        case "help":

                        case "?":

                            $sender->sendMessage($this->helpHeader);

                            $sender->sendMessage(TextFormat::AQUA . "Use/perks to open the perks menu");

                            return true;

                            break;

                        case "break":

                            if (!$sender->hasPermission("perks.break")) {

                                $sender->sendMessage($this->noperm);

                                return true;

                            }

                            $effect = new EffectInstance(Effect::getEffect(3), 999999999, 3, false);

                            $sender->addEffect($effect);

                            $sender->sendMessage($this->prefix . "§1Schneller Abbauen Aktiviert");

                            return true;

                        case "jump":

                            if (!$sender->hasPermission("perks.jump")) {

                                $sender->sendMessage($this->noperm);

                                return true;

                            }

                            $effect = new EffectInstance(Effect::getEffect(8), 999999999, 3, false);

                            $sender->addEffect($effect);

                            $sender->sendMessage($this->prefix . "§r§6Hoher Springen Perk Aktviert");

                            return true;

                        case "breathing":

                            if (!$sender->hasPermission("perks.breathing")) {

                                $sender->sendMessage($this->noperm);

                                return true;

                            }

                            $effect = new EffectInstance(Effect::getEffect(13), 999999999, 3, false);

                            $sender->addEffect($effect);

                            $sender->sendMessage($this->prefix . "§r§6Unterwasser Atem Aktiviert");

                            return true;

                        case "fire":

                            if (!$sender->hasPermission("perks.fire")) {

                                $sender->sendMessage($this->noperm);

                                return true;

                            }

                            $effect = new EffectInstance(Effect::getEffect(12), 999999999, 3, false);

                            $sender->addEffect($effect);

                            $sender->sendMessage($this->prefix . "§r§6Das Fire Resistent Perk §6 ist Aktiviert");

                            return true;

                        case "damage":

                            if (!$sender->hasPermission("perks.damage")) {

                                $sender->sendMessage($this->noperm);

                                return true;

                            }

                            $effect = new EffectInstance(Effect::getEffect(11), 999999999, 3, false);

                            $sender->addEffect($effect);

                            $sender->sendMessage($this->prefix . "§r§6Kein Schaden Perk Aktiviert");

                            return true;

                        case "night":

                            if (!$sender->hasPermission("perks.night")) {

                                $sender->sendMessage($this->noperm);

                                return true;

                            }

                            $effect = new EffectInstance(Effect::getEffect(16), 999999999, 3, false);

                            $sender->addEffect($effect);

                            $sender->sendMessage($this->prefix . "§r§6Nachtsicht Perk Aktiviert");

                            return true;

    }

   }

  }

  return true;

 }

}

                 $sender->sendMessage($this->noperm);

                                return true;

                            }

                            $effect = new EffectInstance(Effect::getEffect(11), 999999999, 3, false);

                            $sender->addEffect($effect);

                            $sender->sendMessage($this->prefix . "§r§6Kein Schaden Perk Aktiviert");

                            return true;

                        case "night":
