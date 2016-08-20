<?php
namespace SSE\Klondike\Move\Event;

use SSE\Cards\Event;
use SSE\Cards\GameID;

final class PileTurnedOver implements Event
{
    /**
     * @var GameID
     */
    private $gameId;

    public function __construct(GameID $gameId)
    {
        $this->gameId = $gameId;
    }

    public function gameID() : GameID
    {
        return $this->gameId;
    }

    public function payload() : string
    {
        return '';
    }

}