<?php
namespace SSE\Cards;

/**
 * Decorator to shuffle decks
 */
final class ShuffleDeck implements Deck
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
	    $p = \range(1, $this->deck->size());
        \shuffle($p);
		return new self(
		    $this->deck->permutation(...$p)
        );
	}

    public function size() : int
    {
        return $this->deck->size();
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
	 */
	public function permutation(int ...$p) : Deck
	{
		return $this->deck->permutation(...$p);
	}
}