<?php
namespace Klondike\Element;

interface Card
{
	//TODO instead of implementing these getters, figure out what they are needed for and add methods
	//public function id() : CardID;
	//public function value() : CardValue;
	//public function visibility() : CardVisibility
	/**
	 * Returns card with changed visibility
	 */
	public function turnOver() : Card;
}