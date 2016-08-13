<?php
namespace Klondike\Value;

final class CardID
{
	private $uuid;
	public function __construct($uuid)
	{
		$this->uuid = $uuid;
	}
}