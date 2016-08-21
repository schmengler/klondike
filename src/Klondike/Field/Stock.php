<?php
namespace SSE\Klondike\Field;

use SSE\Cards\Event;
use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;

interface Stock extends MoveOrigin, MoveTarget
{
	public function turnCard(DiscardPile $target) : Event;
}