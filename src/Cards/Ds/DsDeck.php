<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Cards;
use SSE\Cards\Deck;
use SSE\Cards\InvalidPermutation;
use SSE\Cards\Pile;

final class DsDeck implements Deck
{
	/**
	 * @var Pile
	 */
	private $emptyPile;
	/**
	 * @var Cards
	 */
	private $cards;
	
	public function __construct(Cards $cards, Pile $emptyPile)
	{
		$this->emptyPile = $emptyPile;
		$this->cards = $cards;
	}

	public function permutation(int ...$p) : Deck
	{
	    $cardArray = \iterator_to_array($this->cards);
	    \array_multisort($p, $cardArray);

        $newDeck = clone $this;
        $newDeck->cards = DsCards::fromCards(...$cardArray);
		return $newDeck;
	}

    public function size() : int
    {
        return $this->cards->count();
    }

    public function pile() : Pile
	{
		return $this->emptyPile->add($this->cards);
	}
}