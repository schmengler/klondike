<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\CardRank;
use SSE\Cards\CardVisibility;
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

    /**
     * foundation pile accepts single card with same suit as top card and value + 1
     * or any ace if pile is empty
     *
     * @param Move $move
     * @return bool
     */
    public function accepts(Move $move) : bool
    {
        if ($move->cards()->count() !== 1 || $move->cards()->first()->visibility() == CardVisibility::faceDown()) {
            return false;
        }
        if ($this->pile->count() === 0) {
            return $move->cards()->first()->value()->rank()->equals(CardRank::ace());
        }
        return $this->cardsMatch(
            $move->cards()->first()->value(),
            $this->pile->all()->first()->value()
        );
    }

    public function possibleMoves(MoveTarget ...$availableTargets) : Commands
    {
        // TODO: Implement possibleMoves() method.
        // moves are possible for top card to tableau piles if they accept the card
    }

    /**
     * @param $movedCardValue
     * @param $topCardValue
     * @return bool
     */
    private function cardsMatch($movedCardValue, $topCardValue)
    {
        return $movedCardValue->suit()->equals($topCardValue->suit()) && ($movedCardValue->rank()->difference($topCardValue->rank()) === 1);
    }

}