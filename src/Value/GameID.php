<?php
namespace Klondike\Value;

final class GameID
{
	private $uuid;
	public function __construct(string $uuid)
	{
		$this->uuid = $uuid;
	}
	public function __toString() : string
	{
		return $this->uuid;
	}
}