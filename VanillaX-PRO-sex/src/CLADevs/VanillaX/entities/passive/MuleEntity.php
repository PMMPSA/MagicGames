<?php

namespace CLADevs\VanillaX\entities\passive;

use pocketmine\nbt\tag\CompoundTag;
use CLADevs\VanillaX\entities\VanillaEntity;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class MuleEntity extends VanillaEntity
{

    const NETWORK_ID = EntityIds::MULE;

    public float $width = 1.4;
    public float $height = 1.6;

    protected function initEntity(CompoundTag $nbt): void
    {
        parent::initEntity($nbt);
        $this->setRangeHealth([15, 30]);
    }

    public function getName(): string
    {
        return "Mule";
    }

    public function getXpDropAmount(): int
    {
        return $this->getLastHitByPlayer() ? mt_rand(1, 3) : 0;
    }
}
