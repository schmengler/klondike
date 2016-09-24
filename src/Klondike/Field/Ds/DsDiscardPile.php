<?php
namespace SSE\Klondike\Field\Ds;

use DusanKasan\Knapsack\Collection;
use SSE\Cards\Commands;
use SSE\Cards\Ds\DsCommands;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\Move;
use SSE\Cards\MoveTarget;
use SSE\Cards\MoveWithCallbacks;
use SSE\Klondike\Field\DiscardPile;
use SSE\Klondike\Field\Stock;
use SSE\Klondike\Move\Command\TurnOverPile;
use SSE\Klondike\Move\Event\PileTurnedOver;

final class DsDiscardPile extends DsAbstractField implements DiscardPile
{
    public function moveTopCard() : Move
    {
        return $this->move(1);
    }

    public function turnOver(Stock $target): PileTurnedOver
    {
        $move = new MoveWithCallbacks(
            new DsMove($this, $this->pile->all()->reverse()->turnAll()),
            function() {
                $this->pile->dropAll();
            },
            function() {
            }
        );
        return $move->to($target);
    }

    public function possibleMoves(MoveTarget ...$availableTargets) : Commands
    {
        return DsCommands::fromCommands(...Collection::from($availableTargets)
            ->filter(function(MoveTarget $moveTarget) {
                return $moveTarget instanceof Stock && $moveTarget->accepts(new DsMove($this, $this->pile->all()));
            })
            ->map(function(Stock $moveTarget) {
                return new TurnOverPile(
                    function() use ($moveTarget) {
                        return $this->turnOver($moveTarget);
                    },
                    $this->pileId()
                );
            })
        );
    }

    public function accepts(Move $move) : bool
    {
        return \is_a($move->origin(), Stock::class);
    }

}