<?php
namespace SSE\Cards;

final class PileID
{
	private $uuid;
	public function __construct($uuid)
	{
		$this->uuid = $uuid;
	}
    public function __toString() : string
    {
        return "".$this->uuid;
    }
}