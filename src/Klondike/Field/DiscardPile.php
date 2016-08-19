<?php
namespace SSE\Klondike\Field;

use SSE\Cards\Ds\DsMove;
use SSE\Cards\Move;
use SSE\Klondike\Move\Event\PileTurnedOver;
use SSE\Cards\MoveOrigin;

interface DiscardPile extends MoveOrigin
{
	public function moveTopCard() : Move;
	public function turnOver(): PileTurnedOver;
}