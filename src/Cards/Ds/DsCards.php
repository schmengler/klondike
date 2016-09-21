<?php
namespace SSE\Cards\Ds;

use function DusanKasan\Knapsack\reverse;
use function DusanKasan\Knapsack\map;
use IteratorIterator;
use SSE\Cards\Card;
use SSE\Cards\Cards;

final class DsCards extends \IteratorIterator implements Cards
{
    /**
     * @internal The constructor is only public because it is public in \IteratorIterator
     * @see DsCards::fromCards() as named constructor
     */
	public function __construct(\Ds\Deque $dequeOfCards)
	{
		parent::__construct($dequeOfCards);
	}
	public static function fromCards(Card ...$cards) : DsCards
	{
		return new self(new \Ds\Deque($cards));
	}
	public function current() : Card
	{
		return parent::current();
	}

    public function count() : int
    {
        return $this->getInnerIterator()->count();
    }

    public function first() : Card
    {
        return $this->getInnerIterator()->first();
    }

    public function last() : Card
    {
        return $this->getInnerIterator()->last();
    }

    public function reverse() : Cards
	{
		return self::fromCards(...reverse($this));
	}
	public function turnAll() : Cards
	{
		return self::fromCards(...map($this, function(Card $card) {
			return $card->turnOver();
		}));
	}

	public function getInnerIterator() : \Ds\Deque
    {
        return parent::getInnerIterator();
    }

    public function slice(int $offset, int $length = null) : Cards
    {
        if ($length === null) {
            // slice() checks number of arguments
            return new self($this->getInnerIterator()->slice($offset));
        }
        return new self($this->getInnerIterator()->slice($offset, $length));
    }

    public function merge(Cards $other) : Cards
    {
        return new self($this->getInnerIterator()->merge($other));
    }

    public function filter(callable $filter): Cards
    {
        return new self($this->getInnerIterator()->filter($filter));
    }

}