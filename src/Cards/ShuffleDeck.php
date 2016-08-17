<?php
namespace SSE\Cards;

/**
 * Decorator to shuffle decks
 */
class ShuffleDeck implements Deck
{
	private $deck;
	
	public function __construct(Deck $deck)
	{
		$this->deck = $deck;
	}
	/**
	 * Return random permutation
	 */
	public function shuffle() : Deck
	{
		
	}

	/**
	 * Convert to pile of cards to deal from it
	 */
	public function pile() : Pile
	{
		return $this->deck->pile();
	}

	/**
	 * Return new deck permutated by $p
	 *
	 * @param int[] $p
	 */
	public function permutation(array $p) : Deck
	{
		return $this->deck->permutation($p);
	}
}