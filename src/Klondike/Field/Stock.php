<?php
namespace SSE\Klondike\Field;

use SSE\Cards\Cards;
use SSE\Cards\Event;
use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;

interface Stock extends MoveOrigin, MoveTarget
{
    public function deal(int $cardCount) : Cards;
	public function turnCard(DiscardPile $target) : Event;
}