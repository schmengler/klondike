<?php
namespace SSE\Cards;

final class CardVisibility
{
	private $visible;
	private function __construct(bool $visible)
	{
		$this->visible = $visible;
	}
	public function opposite() : CardVisibility
	{
		return new self(! $this->visible);
	}
	public static function faceDown() : CardVisibility
	{
		return new self(false);
	}
	public static function faceUp() : CardVisibility
	{
		return new self(true);
	}
}