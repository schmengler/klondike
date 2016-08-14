<?php
namespace Klondike\Element;


class DsPile implements Pile
{
	/**
	 * @var \Ds\Deque
	 */
	private $cards;
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
		//TODO validation decorator
		if ($numberOfCards > $this->cards->count()) {
			throw new InvalidPileOperationException(sprintf(
				'Cannot take %d cards from pile of %d cards', $numberOfCards, $this->cards->count()
			));
		}
		return new DsCards(...$this->cards->slice(-$numberOfCards));
	}
	/**
	 * Return pile without top $numberOfCards cards
	 * 
	 * @param unknown $numberOfCards
	 */
	public function drop(int $numberOfCards) : Pile
	{
		if ($numberOfCards > $this->cards->count()) {
			throw new InvalidPileOperationException(sprintf(
				'Cannot drop %d cards from pile of %d cards', $numberOfCards, $this->cards->count()
			));
		}
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