<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Cards;
use SSE\Cards\Event;
use SSE\Cards\Move;
use SSE\Cards\MoveTarget;

final class DsMove implements Move
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