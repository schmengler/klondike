<?php
namespace Klondike\Value;

final class CardValue
{
	private $suit, $rank;
	
	public function __construct(Suit $suit, Rank $rank)
	{
		$this->suit = $suit;
		$this->rank = $rank;
	}
}
