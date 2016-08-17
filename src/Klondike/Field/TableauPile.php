<?php
namespace Klondike\Element;

use SSE\Cards\Ds\DsMove;
use SSE\Klondike\Move\Event\CardTurned;

interface TableauPile extends MoveTarget
{
	public function moveCards(int $count) : DsMove;
	
	public function showCard() : CardTurned;
}