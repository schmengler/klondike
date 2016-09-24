<?php
namespace SSE\Cards;

interface Command
{
    /**
     * Returns pile ID for related pile
     *
     * @return PileID
     */
    public function pileId() : PileID;

    /**
     * Executes command, returns resulting event
     *
     * @return Event
     */
	public function __invoke() : Event;

    /**
     * Returns string representation of command
     *
     * @return string
     */
	public function __toString() : string;
}