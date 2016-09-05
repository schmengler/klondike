<?php
namespace SSE\Cards;


final class MoveTargetWithValidation implements MoveTarget
{
    /**
     * @var MoveTarget
     */
    private $moveTarget;

    public function __construct(MoveTarget $moveTarget)
    {
        $this->moveTarget = $moveTarget;
    }

    public function pileId() : PileID
    {
        return $this->moveTarget->pileId();
    }

    public function receive(Move $move) : Event
    {
        if (! $this->accepts($move)) {
            throw new InvalidMove('Move not accepted by ' . $this->pileId());
        }
        return $this->moveTarget->receive($move);
    }

    public function accepts(Move $move) : bool
    {
        return $this->moveTarget->accepts($move);
    }

}