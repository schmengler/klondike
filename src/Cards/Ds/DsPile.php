<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Card;
use SSE\Cards\Cards;
use SSE\Cards\Pile;

final class DsPile implements Pile
{
	/**
	 * @var DsCards
	 */
	private $cards;

	public static function fromSingleCards(Card ...$cards) : DsPile
	{
		return new self(DsCards::fromCards(...$cards));
	}

	public function __construct(DsCards $cards)
	{
		$this->cards = $cards;
	}

    /**
     * Return $numberOfCards cards from top
     */
	public function top(int $numberOfCards) : Cards
	{
		return $this->cards->slice(-$numberOfCards);
	}

    /**
     * Return pile without top $numberOfCards cards
     */
	public function drop(int $numberOfCards) : Pile
	{
		return new self($this->cards->slice(0, -$numberOfCards));
	}
	/**
	 * Return all cards
	 */
	public function all() : Cards
	{
		return $this->cards;
	}
	/**
	 * Return pile with all cards removed
	 */
	public function dropAll() : Pile
	{
		return new self(DsCards::fromCards());
	}
	/**
	 * Return pile with $cards on top
	 */
	public function add(Cards $cards) : Pile
	{
		return new self($this->cards->merge($cards));
	}

	public function __clone()
    {
        $this->cards = new DsCards($this->cards->getInnerIterator()->copy());
    }

    public function turnTopCard() : Pile
	{
	    $newPile = clone($this);
        $deque = $newPile->cards->getInnerIterator();
        $deque->push($deque->pop()->turnOver());
        return $newPile;
	}
}