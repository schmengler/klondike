<?php
namespace Klondike\Field;

use SSE\Cards\Ds\DsMove;
use SSE\Klondike\Move\Event\PileTurnedOver;
use SSE\Cards\MoveOrigin;

interface DiscardPile extends MoveOrigin
{
	public function moveTopCard() : DsMove;
	public function turnOver(): PileTurnedOver;
}