<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\Cards;
use SSE\Cards\Commands;
use SSE\Cards\Event;
use SSE\Cards\GameID;
use SSE\Cards\Move;
use SSE\Cards\MoveTarget;
use SSE\Cards\Pile;
use SSE\Klondike\Field\DiscardPile;
use SSE\Klondike\Field\Stock;
use SSE\Klondike\Move\Event\CardsMoved;
use SSE\Klondike\Move\Event\PileTurnedOver;

final class DsStock implements Stock
{
    /**
     * @var Pile
     */
    private $pile;
    /**
     * @var GameID
     */
    private $gameId;

    public function __construct(GameID $gameId, Pile $pile)
    {
        $this->pile = $pile;
        $this->gameId = $gameId;
    }

    public function possibleMoves(MoveTarget ...$availableTargets) : Commands
    {
        // TODO: Implement possibleMoves() method.
    }

    public function receive(Move $move) : Event
    {
        $this->pile = $this->pile->add($move->cards());
        return new PileTurnedOver($this->gameId);
    }

    public function accepts(Move $move) : bool
    {
        return $this->pile->count()  === 0 && \is_a($move->origin(), DiscardPile::class);
    }

    public function turnCard(DiscardPile $target) : CardsMoved
    {
        return new CardsMoved($this->gameId, $this->pile->top(1), $this->pileId(), $target->pileId());
    }
}