<?php
namespace SSE\Cards\Fake;
use SSE\Cards\Command;
use SSE\Cards\Event;
use SSE\Cards\PileID;

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
     * @var PileID
     */
    private $pileId;

    /**
     * FakeCommand constructor.
     * @param string $name
     */
    public function __construct(string $name, string $uuid = '')
    {
        $this->name = $name;
        $this->pileId = new PileID($uuid);
    }

    public function pileId(): PileID
    {
        return $this->pileId;
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