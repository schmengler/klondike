<?php
namespace SSE\Klondike\Move\Command;

use SSE\Cards\Command;
use SSE\Cards\Event;

final class TurnCard implements Command
{
    /**
     * @var callable
     */
    private $command;

    public function __construct(callable $command)
    {
        $this->command = $command;
    }
    public function __invoke() : Event
    {
        return \call_user_func($this->command);
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

}