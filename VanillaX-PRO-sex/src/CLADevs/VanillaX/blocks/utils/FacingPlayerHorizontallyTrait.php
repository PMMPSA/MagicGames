<?php

namespace CLADevs\VanillaX\blocks\utils;

use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use pocketmine\block\utils\AnyFacingTrait;

trait FacingPlayerHorizontallyTrait
{
    use AnyFacingTrait;

    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool
    {
        if ($player !== null) {
            $this->facing = match ($player->getHorizontalFacing()) {
                Facing::DOWN, Facing::EAST, Facing::WEST => Facing::UP,
                Facing::SOUTH => Facing::NORTH,
                default => $player->getHorizontalFacing()
            };
        }
        return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
    }

    protected function writeStateToMeta(): int
    {
        return $this->facing;
    }
}
