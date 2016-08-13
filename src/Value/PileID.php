<?php
namespace Klondike\Value;

final class PileID
{
	private $uuid;
	public function __construct($uuid)
	{
		$this->uuid = $uuid;
	}
}