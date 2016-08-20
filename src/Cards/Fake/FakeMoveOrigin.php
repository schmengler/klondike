<?php
namespace SSE\Cards\Fake;

use SSE\Cards\Commands;
use SSE\Cards\MoveOrigin;
use SSE\Cards\MoveTarget;

class FakeMoveOrigin implements MoveOrigin
{
    /**
     * @var Commands
     */
    private $possibleMoves;

    public function __construct(Commands $possibleMoves)
    {
        //TODO allow map from available targets to possible moves if needed
        $this->possibleMoves = $possibleMoves;
    }

    public function possibleMoves(MoveTarget ...$availableTargets) : Commands
    {
        return $this->possibleMoves;
    }

}