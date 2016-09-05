<?php
namespace SSE\Cards;

interface MoveTarget
{
	//TODO implement DsTableauPile and DsFoundationPile
    public function pileId() : PileID;
	public function receive(Move $move) : Event;
	public function accepts(Move $move) : bool;
}