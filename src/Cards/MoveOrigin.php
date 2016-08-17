<?php
namespace SSE\Cards;

interface MoveOrigin
{
	public function possibleMoves(MoveTarget ...$availableTargets) : Commands;
}