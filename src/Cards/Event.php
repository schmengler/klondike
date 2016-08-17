<?php
namespace SSE\Cards;

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