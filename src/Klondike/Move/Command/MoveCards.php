<?php
namespace SSE\Klondike\Move\Command;

use SSE\Cards\Cards;
use SSE\Cards\Command;
use SSE\Cards\Event;
use SSE\Cards\PileID;

final class MoveCards implements Command
{
    /**
     * @var callable
     */
    private $command;
    /**
     * @var PileID
     */
    private $from;
    /**
     * @var PileID
     */
    private $to;
    /**
     * @var int
     */
    private $cardsCount;

    public function __construct(callable $command, PileID $from, PileID $to, int $cardsCount)
    {
        $this->command = $command;
        $this->from = $from;
        $this->to = $to;
        $this->cardsCount = $cardsCount;
    }

    public function pileId(): PileID
    {
        return $this->from;
    }

    public function __invoke() : Event
    {
        return \call_user_func($this->command);
    }

    public function __toString() : string
    {
        return \sprintf("Move %d cards from %s to %s", $this->cardsCount, $this->from, $this->to);
    }

}