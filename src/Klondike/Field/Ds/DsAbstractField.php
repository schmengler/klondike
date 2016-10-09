<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\Ds\DsCards;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\Event;
use SSE\Cards\GameID;
use SSE\Cards\InvalidMove;
use SSE\Cards\Move;
use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;
use SSE\Cards\MoveWithCallbacks;
use SSE\Cards\Pile;
use SSE\Cards\PileID;
use SSE\Klondike\Move\Event\CardsMoved;

/**
 * Base class for fields, provides some default methods for MoveTarget and MoveOrigin interfaces
 *
 * This would be more elegant with multiple inheritance. Still looking for a solution without inheritance.
 */
abstract class DsAbstractField implements MoveOrigin, MoveTarget
{
    /**
     * @var Pile
     */
    protected $pile;

    /**
     * @var bool
     */
    protected $locked = false;
    /**
     * @var GameID
     */
    protected $gameId;

    public function __construct(GameID $gameId, Pile $pile)
    {
        $this->gameId = $gameId;
        $this->pile = $pile;
    }

    public function pileId() : PileID
    {
        return $this->pile->id();
    }

    public function receive(Move $move) : Event
    {
        $this->pile = $this->pile->add($move->cards());
        return new CardsMoved($this->gameId, $move->cards(), $move->origin()->pileId(), $this->pileId());
    }

    protected function move(int $numberOfCards) : Move
    {
        if ($this->locked) {
            throw new InvalidMove('Pile is locked');
        }
        $this->locked = true;
        return new MoveWithCallbacks(
            new DsMove($this, DsCards::fromCards(...$this->pile->top($numberOfCards))),
            function() use ($numberOfCards) {
                $this->pile = $this->pile->drop($numberOfCards);
                $this->locked = false;
            },
            function() {
                $this->locked = false;
            }
        );
    }

    //test
    public function __toString() : string
    {
        return $this->pile->__toString();
    }
}