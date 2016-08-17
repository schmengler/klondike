<?php
namespace SSE\Cards;

interface Move
{
	public function cards() : Cards;
	public function to(MoveTarget $target) : Event;
}