<?php
namespace Klondike\Value;

final class GameID
{
	private $uuid;
	public function __construct($uuid)
	{
		$this->uuid = $uuid;
	}
}