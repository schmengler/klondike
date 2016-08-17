<?php
namespace SSE\Cards\Fake;
use SSE\Cards\Command;
use SSE\Cards\Event;

final class FakeCommand implements Command
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var bool
     */
    private $invoked = false;

    /**
     * FakeCommand constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __invoke() : Event
    {
        $this->invoked = true;
        return FakeEvent::emptyEvent();
    }

    public function __toString() : string
    {
        return $this->name;
    }

    public function invoked() : bool
    {
        return $this->invoked;
    }

}