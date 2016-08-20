<?php
namespace SSE\Cards;

interface MoveTarget
{
	//TODO implement DsStock, DsTableauPile, DsFoundationPile and DsDiscardPile
	// accept() and receive() implement the rules
	//TODO receive() with validation als decorator (SmartMoveTarget?), s.t. rule must only be implemented in accept() 
	public function receive(Move $move) : Event;
	public function accepts(Move $move) : bool;
}