<?php
namespace SSE\Cards;

interface MoveOrigin
{
    public function pileId() : PileID;
	public function possibleMoves(MoveTarget ...$availableTargets) : Commands;
}