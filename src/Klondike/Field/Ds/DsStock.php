<?php
namespace SSE\Klondike\Field\Ds;

use SSE\Cards\Commands;
use SSE\Cards\Ds\DsCommands;
use SSE\Cards\Ds\DsMove;
use SSE\Cards\Event;
use SSE\Cards\Fake\FakeCommands;
use SSE\Cards\GameID;
use SSE\Cards\Move;
use SSE\Cards\MoveTarget;
use SSE\Cards\MoveWithCallbacks;
use SSE\Cards\Pile;
use SSE\Cards\PileID;
use SSE\Klondike\Field\DiscardPile;
use SSE\Klondike\Field\Stock;
use SSE\Klondike\Move\Command\MoveCards;
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

    public function pileId() : PileID
    {
        return $this->pile->id();
    }

    public function possibleMoves(MoveTarget ...$availableTargets) : Commands
    {
        $commands = [];
        foreach ($availableTargets as $moveTarget) {
            if ($moveTarget instanceof DiscardPile && $this->pile->count() > 0) {
                $commands[] = new MoveCards(function() use ($moveTarget) {
                    return $this->turnCard($moveTarget);
                });
            }
        }
        return DsCommands::fromCommands(...$commands);
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

    public function turnCard(DiscardPile $target) : Event
    {
        $move = new MoveWithCallbacks(
            new DsMove($this, $this->pile->top(1)->turnAll()),
            function() {
                $this->pile->drop(1);
            },
            function() {
            }
        );
        return $move->to($target);
    }
}