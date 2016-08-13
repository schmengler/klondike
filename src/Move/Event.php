<?php
namespace Klondike\Move;

use Klondike\Value\GameID;

interface Event
{
	/**
	 * game uuid
	 */
	public function gameID() : GameID;
	/**
	 * incrementing number for order within game
	 */
	public function version() : int;
	/**
	 * json serialized event data
	 */
	public function payload() : string;
}