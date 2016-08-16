<?php
namespace Klondike\Move;

use Klondike\Field\MoveTarget;
use Klondike\Move\Event;
use Klondike\Element\Cards;

final class IncompleteMove implements Move
{
	/**
	 * @var Cards
	 */
	private $cards;
	
	public function __construct(Cards $cards)
	{
		$this->cards = $cards;
	}

	public function cards() : Cards
	{
		return $this->cards;
	}
	
	public function to(MoveTarget $target) : Event
	{
		return $target->receive($this->cards());
	}
}