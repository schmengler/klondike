<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Command;
use SSE\Cards\Commands;

final class DsCommands extends \IteratorIterator implements Commands
{
    /**
     * @internal The constructor is only public because it is public in \IteratorIterator
     * @see DsCommands::fromCommands() as named constructor
     */
    public function __construct(\Ds\Deque $dequeOfCards)
    {
        parent::__construct($dequeOfCards);
    }
    public static function fromCommands(Command ...$commands) : DsCommands
    {
        return new self(new \Ds\Deque($commands));
    }
    public function current() : Command
    {
        return parent::current();
    }

    public function count() : int
    {
        return $this->getInnerIterator()->count();
    }

    public function getInnerIterator() : \Ds\Deque
    {
        return parent::getInnerIterator();
    }

}