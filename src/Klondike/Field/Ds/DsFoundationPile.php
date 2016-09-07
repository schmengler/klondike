<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\Commands;
use SSE\Cards\Move;
use SSE\Cards\MoveTarget;
use SSE\Klondike\Field\FoundationPile;

final class DsFoundationPile extends DsAbstractField implements FoundationPile
{
    public function moveTopCard() : Move
    {
        return $this->move(1);
    }

    public function accepts(Move $move) : bool
    {
        // TODO: Implement accepts() method.
        // foundation pile accepts single card with same suit as top card and value + 1
        // or any ace if pile is empty
    }

    public function possibleMoves(MoveTarget ...$availableTargets) : Commands
    {
        // TODO: Implement possibleMoves() method.
        // moves are possible for top card to tableau piles if they accept the card
    }

}