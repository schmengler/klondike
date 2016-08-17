<?php
namespace Klondike\Field;

use Move\IncompleteMove;
use SSE\Cards\MoveTarget;

interface FoundationPile extends MoveTarget
{
	public function moveTopCard() : IncompleteMove;
}