<?php
namespace SSE\Klondike\Move\Command;

use SSE\Cards\Command;
use SSE\Cards\Event;
use SSE\Cards\PileID;

final class TurnOverPile implements Command
{
    /**
     * @var callable
     */
    private $command;
    /**
     * @var PileID
     */
    private $pile;

    public function __construct(callable $command, PileID $pile)
    {
        $this->command = $command;
        $this->pile = $pile;
    }

    public function pileId(): PileID
    {
        return $this->pile;
    }

    public function __invoke() : Event
    {
        return \call_user_func($this->command);
    }

    public function __toString() : string
    {
        return \sprintf("Turn over %s", $this->pile);
    }
}