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
use SSE\Cards\PileID;
use SSE\Klondike\Field\DiscardPile;
use SSE\Cards\Commands;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\MoveTarget;
use SSE\Klondike\Field\Stock;
use SSE\Klondike\Move\Event\CardsMoved;
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

    public function pileId() : PileID
    {
        return $this->pile->id();
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
        return new CardsMoved($this->gameId, $move->cards(), $move->origin()->pileId(), $this->pileId());
    }

    public function accepts(Move $move) : bool
    {
        return \is_a($move->origin(), Stock::class);
    }


}