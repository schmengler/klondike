<?php
namespace Klondike\Element;

use Klondike\Move\IncompleteMove;
use Klondike\Move\Event\CardTurned;

interface TableauPile extends MoveTarget
{
	public function moveCards(int $count) : IncompleteMove;
	
	public function showCard() : CardTurned;
}