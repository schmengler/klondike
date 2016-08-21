<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Cards;
use SSE\Cards\Event;
use SSE\Cards\InvalidMove;
use SSE\Cards\Move;
use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;

final class DsMove implements Move
{
	/**
	 * @var Cards
	 */
	private $cards;
    /**
     * @var MoveOrigin
     */
    private $origin;
    /**
     * @var bool
     */
    private $finished;

    public function __construct(MoveOrigin $origin, Cards $cards)
	{
		$this->cards = $cards;
        $this->origin = $origin;
    }

    public function origin() : MoveOrigin
    {
        return $this->origin;
    }

    public function cards() : Cards
	{
		return $this->cards;
	}
	
	public function to(MoveTarget $target) : Event
	{
	    if ($this->finished) {
	        throw new InvalidMove('Move already finished');
        }
	    $this->finished = true;
		return $target->receive($this);
	}
}