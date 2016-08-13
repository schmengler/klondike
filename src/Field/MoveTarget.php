<?php
namespace Klondike\Field;

use Klondike\Move\IncompleteMove;
use Klondike\Move\Event\CardsMoved;

interface MoveTarget
{
	public function receive(IncompleteMove $move) : CardsMoved;
	public function accepts(IncompleteMove $move) : bool;
}