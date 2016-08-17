<?php
namespace SSE\Cards;

/**
 * Decorator to validate allowed actions
 */
final class PileWithValidation implements Pile
{
	private $pile;
	public function __construct(Pile $pile)
	{
		$this->pile = $pile;
	}
	/**
	 * Return $numberOfCards cards from top
	 *
	 * @param int $numberOfCards
	 */
	public function take(int $numberOfCards) : Cards
	{
		$totalCards = $this->totalCards();
		if ($numberOfCards > $totalCards) {
			throw new InvalidPileOperation(sprintf(
					'Cannot take %d cards from pile of %d cards', $numberOfCards, $totalCards
			));
		}
		return $this->pile->take($numberOfCards);
	}
	/**
	 * Return all cards
	 */
	public function takeAll() : Cards
	{
		return $this->pile->takeAll();
	}
	/**
	 * Return pile without top $numberOfCards cards
	 *
	 * @param int $numberOfCards
	 */
	public function drop(int $numberOfCards) : Pile
	{
		$totalCards = $this->totalCards();
		if ($numberOfCards > $totalCards) {
			throw new InvalidPileOperation(sprintf(
				'Cannot drop %d cards from pile of %d cards', $numberOfCards, $totalCards
			));
		}
		return $this->pile->drop($numberOfCards);
	}
	/**
	 * Return pile with all cards removed
	 */
	public function dropAll() : Pile
	{
		return $this->pile->dropAll();
	}
	/**
	 * Return pile with $cards on top
	 *
	 * @param Cards $cards
	 */
	public function add(Cards $cards) : Pile
	{
		return $this->pile->add($cards);
	}
	/**
	 * Return pile with top card turned over
	 */
	public function turnTopCard() : Pile
	{
		$totalCards = $this->totalCards();
		if ($totalCards === 0) {
			throw new InvalidPileOperation('Cannot turn top card of empty pile');
		}
		return $this->pile->turnTopCard();
	}
	private function totalCards() : int
	{
		return $this->takeAll()->count();
	}
}