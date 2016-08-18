<?php
namespace SSE\Cards;

interface Event
{
	/**
	 * game uuid
	 */
	public function gameID() : GameID;
	/**
	 * json serialized event data
	 */
	public function payload() : string;
}