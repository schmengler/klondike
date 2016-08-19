<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\Ds\DsCards;
use SSE\Cards\InvalidMove;
use SSE\Cards\Move;
use SSE\Cards\MoveWithCallbacks;
use SSE\Cards\Pile;
use SSE\Klondike\Field\DiscardPile;
use SSE\Cards\Commands;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\MoveTarget;
use SSE\Klondike\Move\Event\PileTurnedOver;

final class DsDiscardPile implements DiscardPile
{
    /**
     * @var Pile
     */
    private $pile;

    /**
     * @var bool
     */
    private $locked = false;

    /**
     * DsDiscardPile constructor.
     * @param Pile $pile
     */
    public function __construct(Pile $pile)
    {
        $this->pile = $pile;
    }

    public function moveTopCard() : Move
    {
        if ($this->locked) {
            throw new InvalidMove('Pile is locked');
        }
        $this->locked = true;
        return new MoveWithCallbacks(
            new DsMove(DsCards::fromCards(...$this->pile->top(1))),
            function() {
                $this->pile->drop(1);
                $this->locked = false;
            },
            function() {
                $this->locked = false;
            }
        );
    }

    public function turnOver(): PileTurnedOver
    {
        // TODO: Implement turnOver() method.
    }

    public function possibleMoves(MoveTarget ...$availableTargets) : Commands
    {
        // TODO: Implement possibleMoves() method.
    }

}