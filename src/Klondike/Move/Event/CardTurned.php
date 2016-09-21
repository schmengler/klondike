<?php
namespace SSE\Klondike\Move\Event;

use SSE\Cards\Event;
use SSE\Cards\GameID;
use SSE\Cards\PileID;

final class CardTurned implements Event
{
    /**
     * @var GameID
     */
    private $gameId;
    /**
     * @var PileID
     */
    private $pileId;

    public function __construct(GameID $gameId, PileID $pileId)
    {
        $this->gameId = $gameId;
        $this->pileId = $pileId;
    }

    public function gameID() : GameID
    {
        return $this->gameId;
    }

    public function payload() : string
    {
        //TODO construct unserializable payload
        return '';
    }

}