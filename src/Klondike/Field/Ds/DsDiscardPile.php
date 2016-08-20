<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\Cards;
use SSE\Cards\Ds\DsCards;
use SSE\Cards\Event;
use SSE\Cards\GameID;
use SSE\Cards\InvalidMove;
use SSE\Cards\Move;
use SSE\Cards\MoveWithCallbacks;
use SSE\Cards\Pile;
use SSE\Klondike\Field\DiscardPile;
use SSE\Cards\Commands;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\MoveTarget;
use SSE\Klondike\Field\Stock;
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
     * @var GameID
     */
    private $gameId;

    public function __construct(GameID $gameId, Pile $pile)
    {
        $this->gameId = $gameId;
        $this->pile = $pile;
    }

    public function moveTopCard() : Move
    {
        if ($this->locked) {
            throw new InvalidMove('Pile is locked');
        }
        $this->locked = true;
        return new MoveWithCallbacks(
            new DsMove($this, DsCards::fromCards(...$this->pile->top(1))),
            function() {
                $this->pile->drop(1);
                $this->locked = false;
            },
            function() {
                $this->locked = false;
            }
        );
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
        // TODO: Implement possibleMoves() method.
    }

    public function receive(Move $move) : Event
    {
        // TODO: Implement receive() method.
    }

    public function accepts(Move $move) : bool
    {
        // TODO: Implement accepts() method.
    }


}