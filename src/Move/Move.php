<?php
namespace Klondike\Move;

use Klondike\Field\MoveTarget;
use Klondike\Element\Cards;

interface Move
{
	public function cards() : Cards;
	public function to(MoveTarget $target) : Event;
}