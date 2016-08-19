<?php
namespace SSE\Cards;

interface Card
{
	public function id() : CardID;
	public function value() : CardValue;
	public function visibility() : CardVisibility;
	/**
	 * Returns card with changed visibility
	 */
	public function turnOver() : Card;
}