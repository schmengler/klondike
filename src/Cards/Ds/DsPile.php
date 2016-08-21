<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Card;
use SSE\Cards\Cards;
use SSE\Cards\Pile;
use SSE\Cards\PileID;

final class DsPile implements Pile
{
	/**
	 * @var DsCards
	 */
	private $cards;
    /**
     * @var PileID
     */
    private $pileId;

    public static function fromSingleCards(PileID $pileId, Card ...$cards) : DsPile
	{
		return new self($pileId, DsCards::fromCards(...$cards));
	}

	public function __construct(PileID $pileId, DsCards $cards)
	{
        $this->pileId = $pileId;
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
		return new self($this->pileId, $this->cards->slice(0, -$numberOfCards));
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
		return new self($this->pileId, DsCards::fromCards());
	}
	/**
	 * Return pile with $cards on top
	 */
	public function add(Cards $cards) : Pile
	{
		return new self($this->pileId, $this->cards->merge($cards));
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

    public function count() : int
    {
        return $this->all()->count();
    }

}