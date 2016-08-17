<?php
namespace SSE\Cards;

use SSE\Cards\CardRank;
use SSE\Cards\CardSuit;

final class CardValue
{
	private $suit, $rank;
	
	public function __construct(CardRank $rank, CardSuit $suit)
	{
		$this->suit = $suit;
		$this->rank = $rank;
	}

    public function rank() : CardRank
    {
        return $this->rank;
    }

    public function suit() : CardSuit
    {
        return $this->suit;
    }
}
