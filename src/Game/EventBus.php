<?php
namespace Klondike\Game;

use Klondike\Value\GameID;
interface EventBus
{
	public function gameID() : GameID;
	public function nextVersion() : int;
}