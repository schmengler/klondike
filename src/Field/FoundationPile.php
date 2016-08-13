<?php
namespace Klondike\Field;

use Move\IncompleteMove;

interface FoundationPile extends MoveTarget
{
	public function moveTopCard() : IncompleteMove;
}