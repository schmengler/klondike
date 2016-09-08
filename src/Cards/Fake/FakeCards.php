<?php
namespace SSE\Cards\Fake;

use ArrayIterator;
use DusanKasan\Knapsack\Collection;
use SSE\Cards\Card;
use SSE\Cards\Cards;

/**
 * Fake cards without value, for testing
 */
final class FakeCards extends \ArrayIterator implements Cards
{
	public function __construct(Collection $collection)
	{
		parent::__construct($collection->toArray());
	}
	public static function fromUuids(string ...$uuids) : FakeCards
	{
		return new self(
			Collection::from($uuids)
				->map(function(string $uuid) {
					return FakeCard::fromUuid($uuid);
				})
		);
	}
	public function current() : Card
	{
		return parent::current();
	}
	public function reverse() : Cards
	{
		return new self(
			Collection::from($this)
				->reverse()
				->values()
		);
	}
	public function turnAll() : Cards
	{
		return new self(
		    Collection::from($this)
            ->map(function(Card $card) {
                return $card->turnOver();
            })
        );
	}

    public function slice(int $offset, int $length = null) : Cards
    {
        return new self(
            Collection::from(
                // Collection::slice() behaves differently and cannot take sliced from the end
                array_slice($this->getArrayCopy(), $offset, $length, false)
            )
        );
    }

    public function merge(Cards $other) : Cards
    {
        return new self(
            Collection::from($this)
                ->concat($other)
                ->values()
        );
    }

    public function first() : Card
    {
        return \array_values($this->getArrayCopy())[0];
    }

    public function last() : Card
    {
        return \array_values($this->getArrayCopy())[$this->count() - 1];
    }

}