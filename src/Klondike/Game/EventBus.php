<?php
namespace SSE\Klondike\Game;

use SSE\Cards\GameID;
interface EventBus
{
	public function gameID() : GameID;
	public function nextVersion() : int;
}