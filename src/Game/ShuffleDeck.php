<?php
namespace Klondike\Game;

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
}