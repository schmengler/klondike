<?php
namespace Klondike\Move\Event;

use Klondike\Move\Event;
use Klondike\Value\GameID;

final class FakeEventBuilder implements EventBuilder
{
	private $gameId;
	private static $nextVersions = [];
	private $payload;
	
	public function __construct(GameID $gameId)
	{
		$this->gameId = $gameId;
		self::$nextVersions[(string)$gameId] = self::$nextVersions[(string)$gameId] ?? 1; 
	}
	public function withPayload(string $payload) : EventBuilder
	{
		$builder = clone $this;
		$builder->payload = $payload;
		return $builder;
	}
	public function create() : Event
	{
		return new FakeEvent($this->gameId, self::$nextVersions[(string)$this->gameId]++, $this->payload);
	}
}