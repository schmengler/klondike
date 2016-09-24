<?php
namespace SSE\Klondike\Field\Ds;

use DusanKasan\Knapsack\Collection;
use SSE\Cards\CardRank;
use SSE\Cards\CardValue;
use SSE\Cards\CardVisibility;
use SSE\Cards\Commands;
use SSE\Cards\Ds\DsCards;
use SSE\Cards\Ds\DsCommands;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\Move;
use SSE\Cards\MoveTarget;
use SSE\Klondike\Field\FoundationPile;
use SSE\Klondike\Move\Command\MoveCards;

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
        return DsCommands::fromCommands(...Collection::from($availableTargets)
            ->filter(function(MoveTarget $target) {
                return $target->accepts(new DsMove($this, DsCards::fromCards(...$this->pile->top(1))));
            })
            ->map(function(MoveTarget $target) {
                return new MoveCards(
                    function() use ($target) {
                        return $this->moveTopCard()->to($target);
                    },
                    $this->pileId(), $target->pileId(), 1
                );
            })
        );
    }

    private function cardsMatch(CardValue $movedCardValue, CardValue $topCardValue) : bool
    {
        return $movedCardValue->suit()->equals($topCardValue->suit()) && ($movedCardValue->rank()->difference($topCardValue->rank()) === 1);
    }

}