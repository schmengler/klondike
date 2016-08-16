<?php
namespace Klondike\Field;

use Klondike\Move\Event;
use Klondike\Element\Cards;

interface MoveTarget
{
	//TODO implement DsStock, DsTableauPile, DsFoundationPile and DsDiscardPile
	// accept() and receive() implement the rules
	//TODO receive() with validation als decorator (SmartMoveTarget?), s.t. rule must only be implemented in accept() 
	public function receive(Cards $cards) : Event;
	public function accepts(Cards $cards) : bool;
}