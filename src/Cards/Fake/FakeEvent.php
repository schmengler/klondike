<?php
namespace SSE\Cards\Fake;

use SSE\Cards\Event;
use SSE\Cards\GameID;

final class FakeEvent implements Event
{
	private $gameId, $version, $payload;
	public function __construct(GameID $gameId, int $version, string $payload)
	{
		$this->gameId = $gameId;
		$this->version = $version;
		$this->payload = $payload;
	}
	public function gameID() : GameID
	{
		return $this->gameId;
	}
	public function version() : int
	{
		return $this->version;
	}
	public function payload() : string
	{
		return $this->payload;
	}
}