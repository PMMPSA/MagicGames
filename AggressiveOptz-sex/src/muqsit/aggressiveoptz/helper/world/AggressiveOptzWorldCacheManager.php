<?php

declare(strict_types=1);

namespace muqsit\aggressiveoptz\helper\world;

use pocketmine\world\World;
use function array_key_exists;
use pocketmine\event\EventPriority;
use pocketmine\event\world\ChunkLoadEvent;
use pocketmine\event\world\WorldLoadEvent;
use muqsit\aggressiveoptz\AggressiveOptzAPI;
use pocketmine\event\world\ChunkUnloadEvent;
use pocketmine\event\world\WorldUnloadEvent;

final class AggressiveOptzWorldCacheManager
{
	/** @var AggressiveOptzWorldCache[] */
	private array $worlds = [];

	public function __construct()
	{
	}

	public function init(AggressiveOptzAPI $api): void
	{
		$api->registerEvent(function (WorldLoadEvent $event): void {
			$this->onWorldLoad($event->getWorld());
		}, EventPriority::LOWEST);
		$api->registerEvent(function (WorldUnloadEvent $event): void {
			$this->onWorldUnload($event->getWorld());
		}, EventPriority::MONITOR);
		$api->registerEvent(function (ChunkLoadEvent $event): void {
			$this->onChunkLoad($event->getWorld(), $event->getChunkX(), $event->getChunkZ());
		}, EventPriority::LOWEST);
		$api->registerEvent(function (ChunkUnloadEvent $event): void {
			$this->onChunkUnload($event->getWorld(), $event->getChunkX(), $event->getChunkZ());
		}, EventPriority::MONITOR);

		foreach ($api->getServer()->getWorldManager()->getWorlds() as $world) {
			$this->onWorldLoad($world);
		}
	}

	private function onWorldLoad(World $world): AggressiveOptzWorldCache
	{
		return $this->worlds[$world->getId()] = new AggressiveOptzWorldCache($world);
	}

	private function onWorldUnload(World $world): void
	{
		unset($this->worlds[$world->getId()]);
	}

	private function onChunkLoad(World $world, int $x, int $z): void
	{
		$this->worlds[$world->getId()]->onChunkLoad($x, $z);
	}

	private function onChunkUnload(World $world, int $x, int $z): void
	{
		if (array_key_exists($id = $world->getId(), $this->worlds)) { // WorldUnloadEvent is called before ChunkUnloadEvent :(
			$this->worlds[$id]->onChunkUnload($x, $z);
		}
	}

	public function get(World $world): AggressiveOptzWorldCache
	{
		if (isset($this->worlds[$world->getId()])) {
			return $this->worlds[$world->getId()];
		}
		return $this->onWorldLoad($world);
	}
}
