<?php
namespace Klondike\Field;

use Klondike\Move\IncompleteMove;
use Klondike\Move\Event\PileTurnedOver;

interface DiscardPile extends MoveOrigin
{
	public function moveTopCard() : IncompleteMove;
	public function turnOver(): PileTurnedOver;
}