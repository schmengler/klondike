<?php
namespace Klondike\Element;

use function DusanKasan\Knapsack\reverse;
use function DusanKasan\Knapsack\map;

final class DsCards extends \IteratorIterator implements Cards
{
	public function __construct(Card ...$cards)
	{
		parent::__construct(new \Ds\Deque($cards));
	}
	public function current() : Card
	{
		return parent::current();
	}
	public function reverse() : Cards
	{
		return new self(...reverse($this));
	}
	public function turnAll() : Cards
	{
		return new self(...map($this, function(Card $card) {
			return $card->turnOver();
		}));
	}
}