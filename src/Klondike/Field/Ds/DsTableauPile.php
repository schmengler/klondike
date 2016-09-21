<?php
namespace SSE\Klondike\Field\Ds;


use DusanKasan\Knapsack\Collection;
use SSE\Cards\CardVisibility;
use SSE\Cards\Commands;
use SSE\Cards\Ds\DsCards;
use SSE\Cards\Ds\DsCommands;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\Move;
use SSE\Cards\MoveTarget;
use SSE\Klondike\Field\TableauPile;
use SSE\Klondike\Move\Command\MoveCards;
use SSE\Klondike\Move\Command\TurnCard;
use SSE\Klondike\Move\Event\CardTurned;

class DsTableauPile extends DsAbstractField implements TableauPile
{
    public function possibleMoves(MoveTarget ...$availableTargets): Commands
    {
        if ($this->countVisibleCards() === 0 && $this->pile->count() > 0) {
            return DsCommands::fromCommands(new TurnCard(function() {
                return $this->showCard();
            }));
        }
        // OK this works but a nested loop would be more understandable...
        return DsCommands::fromCommands(...Collection::from($availableTargets)
            ->map(function(MoveTarget $target) {
                return Collection::range(0, $this->countVisibleCards() - 1)
                    ->zip(Collection::repeat($target));
            })
            ->flatten(1)
            ->filter(function(Collection $cardCountAndTarget) {
                return $cardCountAndTarget->second()->accepts(
                    new DsMove($this, DsCards::fromCards(...$this->pile->top($cardCountAndTarget->first())))
                );
            })
            ->map(function(Collection $cardCountAndTarget) {
                return new MoveCards(function() use ($cardCountAndTarget) {
                    return $this->moveCards($cardCountAndTarget->first())->to($cardCountAndTarget->second());
                });
            })
        );
    }

    public function accepts(Move $move): bool
    {
        //TODO extract comparison to cards decorator
        $bottomMovedCard = $move->cards()->first();
        $pileTopCard = $this->pile->all()->last();
        return $pileTopCard->visibility() == CardVisibility::faceUp()
            && ! $bottomMovedCard->value()->suit()->colorEquals($pileTopCard->value()->suit())
            && $pileTopCard->value()->rank()->difference($bottomMovedCard->value()->rank()) === 1;
    }

    public function moveCards(int $count): Move
    {
        return $this->move($count);
    }

    public function showCard(): CardTurned
    {
        $this->pile->turnTopCard();
        return new CardTurned($this->gameId, $this->pileId());
    }

    private function countVisibleCards()
    {
        return $this->pile->countVisible();
    }

}