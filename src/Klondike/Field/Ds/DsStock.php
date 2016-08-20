<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\Cards;
use SSE\Cards\Commands;
use SSE\Cards\Event;
use SSE\Cards\GameID;
use SSE\Cards\Move;
use SSE\Cards\MoveTarget;
use SSE\Cards\Pile;
use SSE\Klondike\Field\CardMoved;
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
        //TODO only accept move from discard pile
        $this->pile = $this->pile->add($move->cards());
        return new PileTurnedOver($this->gameId);
    }

    public function accepts(Move $move) : bool
    {
        // TODO: Implement accepts() method.
    }


    public function turnCard(DiscardPile $target) : CardsMoved
    {
        // TODO: Implement turnCard() method.
    }
}