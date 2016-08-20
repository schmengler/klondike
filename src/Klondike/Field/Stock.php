<?php
namespace SSE\Klondike\Field;

use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;
use SSE\Klondike\Move\Event\CardsMoved;

interface Stock extends MoveOrigin, MoveTarget
{
	public function turnCard(DiscardPile $target) : CardsMoved;
}