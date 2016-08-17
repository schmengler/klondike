<?php
namespace Klondike\Field;

use Klondike\Move\CardsMoved;

interface Stock
{
	public function turnCard() : CardMoved;
}