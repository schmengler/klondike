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
	 */
	public function top(int $numberOfCards) : Cards
	{
		$totalCards = $this->totalCards();
		if ($numberOfCards > $totalCards) {
			throw new InvalidPileOperation(sprintf(
					'Cannot take %d cards from pile of %d cards', $numberOfCards, $totalCards
			));
		}
		return $this->pile->top($numberOfCards);
	}
	/**
	 * Return all cards
	 */
	public function all() : Cards
	{
		return $this->pile->all();
	}
	/**
	 * Return pile without top $numberOfCards cards
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
        if ($this->totalCards() === 0) {
			throw new InvalidPileOperation('Cannot turn top card of empty pile');
		}
		return $this->pile->turnTopCard();
	}

    public function count() : int
    {
        return $this->pile->count();
    }

    private function totalCards() : int
	{
	    return $this->count();
	}
}