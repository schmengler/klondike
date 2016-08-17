<?php
namespace SSE\Cards;

use SSE\Cards\MoveTarget;

interface Move
{
	public function cards() : Cards;
	public function to(MoveTarget $target) : Event;
}