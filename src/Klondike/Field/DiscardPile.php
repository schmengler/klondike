<?php
namespace SSE\Klondike\Field;

use SSE\Cards\Move;
use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;
use SSE\Klondike\Move\Event\PileTurnedOver;

interface DiscardPile extends MoveOrigin, MoveTarget
{
	public function moveTopCard() : Move;
	public function turnOver(Stock $target): PileTurnedOver;
}