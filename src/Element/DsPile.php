<?php
namespace Klondike\Element;


final class DsPile implements Pile
{
	/**
	 * @var \Ds\Deque
	 */
	private $cards;
	public static function fromSingleCards(Card ...$cards)
	{
		return new self(new DsCards(...$cards));
	}
	public function __construct(Cards $cards)
	{
		$this->cards = new \Ds\Deque($cards);
	}
	/**
	 * Return $numberOfCards cards from top
	 * 
	 * @param int $numberOfCards
	 */
	public function take(int $numberOfCards) : Cards
	{
		return new DsCards(...$this->cards->slice(-$numberOfCards));
	}
	/**
	 * Return pile without top $numberOfCards cards
	 * 
	 * @param unknown $numberOfCards
	 */
	public function drop(int $numberOfCards) : Pile
	{
		return new self(new DsCards(...$this->cards->slice(0, -$numberOfCards)));
	}
	/**
	 * Return all cards
	 */
	public function takeAll() : Cards
	{
		return new DsCards(...$this->cards);
	}
	/**
	 * Return pile with all cards removed
	 */
	public function dropAll() : Pile
	{
		return new self(new DsCards());
	}
	/**
	 * Return pile with $cards on top
	 * 
	 * @param Cards $cards
	 */
	public function add(Cards $cards) : Pile
	{
		$cardsForNewPile = $this->cards->copy();
		$cardsForNewPile->push(...$cards);
		return new self(new DsCards(...$cardsForNewPile));
	}
	
	public function turnTopCard() : Pile
	{
		$cardsForNewPile = $this->cards->copy();
		$topCard = $cardsForNewPile->pop();
		$cardsForNewPile->push($topCard->turnOver());
		return new self(new DsCards(...$cardsForNewPile));
	}
}