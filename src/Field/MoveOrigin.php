<?php
namespace Klondike\Field;

use Klondike\Move\IncompleteMove;
use Klondike\Move\Event\CardsMoved;

interface MoveOrigin
{
	public function possibleMoves(MoveTarget $availableTargets...) : Commands
}