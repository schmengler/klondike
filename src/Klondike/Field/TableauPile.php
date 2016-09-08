<?php
namespace SSE\Klondike\Field;

use SSE\Cards\Ds\DsMove;
use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;
use SSE\Klondike\Move\Event\CardTurned;

interface TableauPile extends MoveTarget, MoveOrigin
{
	public function moveCards(int $count) : DsMove;
	
	public function showCard() : CardTurned;
}