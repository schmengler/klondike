<?php
namespace SSE\Cards;

use SSE\Cards\CardRank;
use SSE\Cards\CardSuit;

final class CardValue
{
	private $suit, $rank;
	
	public function __construct(CardSuit $suit, CardRank $rank)
	{
		$this->suit = $suit;
		$this->rank = $rank;
	}
}
