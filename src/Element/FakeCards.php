<?php
namespace Klondike\Element;

use DusanKasan\Knapsack\Collection;
/**
 * Fake card without value, for testing
 */
final class FakeCards extends \ArrayIterator implements Cards
{
	public function __construct(Collection $collection)
	{
		parent::__construct($collection->toArray());
	}
	public static function fromUuids(string ...$uuids)
	{
		return new self(
			Collection::from($uuids)
				->map(function(string $uuid) {
					return new FakeCard($uuid);
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
		
	}
}