<?php
namespace SSE\Cards\Fake;

use SSE\Cards\Event;
use SSE\Cards\EventBuilder;
use SSE\Cards\GameID;

final class FakeEventBuilder implements EventBuilder
{
	private $gameId;
	private $payload;
	
	public function __construct(GameID $gameId)
	{
		$this->gameId = $gameId;
	}
	public function withPayload(string $payload) : EventBuilder
	{
		$builder = clone $this;
		$builder->payload = $payload;
		return $builder;
	}
	public function create() : Event
	{
		return new FakeEvent($this->gameId, $this->payload);
	}
}