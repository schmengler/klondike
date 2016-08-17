<?php
namespace SSE\Cards\Fake;

use SSE\Cards\CardID;
use SSE\Cards\Card;
use SSE\Cards\CardVisibility;
/**
 * Fake card without value, for testing
 */
final class FakeCard implements Card
{
	private $cardId;
	private $visibility;
	public function __construct(string $uuid, CardVisibility $visibility = null)
	{
		$this->cardId = new CardID($uuid);
		$this->visibility = $visibility ?? CardVisibility::faceDown();
	}
	public function turnOver() : Card
	{
		$clone = clone $this;
		$clone->visibility = $clone->visibility->opposite();
		return $clone; 
	}
}