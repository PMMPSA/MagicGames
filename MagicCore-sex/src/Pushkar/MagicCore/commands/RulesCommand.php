<?php

namespace Pushkar\MagicCore\commands;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Pushkar\MagicCore\forms\InformationForm;

class RulesCommand extends Command
{

    public function __construct()
    {
        parent::__construct("rules", "§eServer Rules");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): mixed
    {
        if ($sender instanceof Player) {
            (new InformationForm())->INFOFOR($sender);
            return true;
        }
        return false;
    }
}
