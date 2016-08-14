<?php
namespace Klondike\Element;

use Klondike\Value\CardID;
use Klondike\Value\CardValue;
use Klondike\Value\Suit;
use Klondike\Value\Rank;
use Klondike\Value\CardVisibility;

class DsCardsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var DsCards
	 */
	private $cards;
	public function testIterator()
	{
		$cards = [new FakeCard('xxx'), new FakeCard('yyy')];
		$this->cards = new DsCards(...$cards);
		$this->assertEquals($cards, \iterator_to_array($this->cards));
	}
	public function testReverse()
	{
		$cards = [new FakeCard('aaa'), new FakeCard('bbb')];
		$this->cards = new DsCards(...$cards);
		$this->assertEquals(\array_reverse($cards), \iterator_to_array($this->cards->reverse()));
	}
	public function testTurnAll()
	{
		$cards = [
			new FakeCard('hello'),
			new FakeCard('world'),
		];
		$turnedCards = [
			new FakeCard('hello', CardVisibility::faceUp()),
			new FakeCard('world', CardVisibility::faceUp()),
		];
		$this->cards = new DsCards(...$cards);
		$this->assertEquals($turnedCards, \iterator_to_array($this->cards->turnAll()));
	}
}