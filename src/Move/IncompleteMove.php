<?php
namespace Move;

use Klondike\Element\MoveTarget;
use Klondike\Move\Event;

class IncompleteMove
{
	public function to(MoveTarget $target) : Event
	{
		return $target->finishMove($this);
	}
}