<?php
namespace Klondike\Element;

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
}