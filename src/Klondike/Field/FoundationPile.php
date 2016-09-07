<?php
namespace SSE\Klondike\Field;

use SSE\Cards\Move;
use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;

interface FoundationPile extends MoveTarget, MoveOrigin
{
	public function moveTopCard() : Move;
}