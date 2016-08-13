<?php
namespace Klondike\Game;

use Klondike\Element\Cards;
use Klondike\Element\Pile;

class DeckOfCards implements Deck
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

	public function permutation(array $p) : Deck
	{
		
	}
	
	public function pile() : Pile
	{
		//TODO convert to pile, to deal from it
	}
}