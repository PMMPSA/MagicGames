<?php

namespace CLADevs\VanillaX\items\types;

use pocketmine\item\Durable;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemIdentifier;

class ShieldItem extends Durable
{

    public function __construct()
    {
        parent::__construct(new ItemIdentifier(ItemIds::SHIELD, 0), "Shield");
    }

    public function getMaxDurability(): int
    {
        return 336;
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }
}
