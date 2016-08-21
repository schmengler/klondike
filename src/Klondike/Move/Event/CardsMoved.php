<?php
namespace SSE\Klondike\Move\Event;

use SSE\Cards\Cards;
use SSE\Cards\Event;
use SSE\Cards\GameID;
use SSE\Cards\PileID;

final class CardsMoved implements Event
{
    /**
     * @var GameID
     */
    private $gameId;
    /**
     * @var Cards
     */
    private $cards;
    /**
     * @var PileID
     */
    private $from;
    /**
     * @var PileID
     */
    private $to;

    public function __construct(GameID $gameId, Cards $cards, PileID $from, PileID $to)
    {
        $this->gameId = $gameId;
        $this->cards = $cards;
        $this->from = $from;
        $this->to = $to;
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