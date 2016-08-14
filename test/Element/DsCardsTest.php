<?php
namespace Klondike\Element;

use Klondike\Value\CardID;
use Klondike\Value\CardValue;
use Klondike\Value\Suit;
use Klondike\Value\Rank;
use Klondike\Value\CardVisibility;

class DsCardsTest extends \PHPUnit_Framework_TestCase
{
	private $cards;
	public function testIterator()
	{
		$cards = [new FakeCard('xxx'), new FakeCard('yyy')];
		$this->cards = new DsCards(...$cards);
		$this->assertEquals($cards, \iterator_to_array($this->cards));
	}
}