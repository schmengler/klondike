<?php
namespace SSE\Cards\Fake;

use SSE\Cards\Event;
use SSE\Cards\GameID;

final class FakeEvent implements Event
{
	private $gameId, $payload;
	public function __construct(GameID $gameId, string $payload)
	{
		$this->gameId = $gameId;
		$this->payload = $payload;
	}
	public static function emptyEvent() : FakeEvent
    {
        return new self(new GameID(''), '');
    }
	public function gameID() : GameID
	{
		return $this->gameId;
	}
	public function payload() : string
	{
		return $this->payload;
	}
}