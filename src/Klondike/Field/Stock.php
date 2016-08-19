<?php
namespace SSE\Klondike\Field;

use Klondike\Move\CardsMoved;

interface Stock
{
	public function turnCard() : CardMoved;
}