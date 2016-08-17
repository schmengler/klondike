<?php
namespace SSE\Cards;

interface Deck
{
	/**
	 * Convert to pile of cards to deal from it
	 */
	public function pile() : Pile;

    /**
     * Return new deck permutated by $p
     */
	public function permutation(int ...$p) : Deck;
}
