<?php
namespace SSE\Cards\Ds;

use SSE\Cards\CardVisibility;
use SSE\Cards\Fake\FakeCard;

class DsCardsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var DsCards
	 */
	private $cards;
	public function testIterator()
	{
		$cards = [FakeCard::fromUuid('xxx'), FakeCard::fromUuid('yyy')];
		$this->cards = new DsCards(...$cards);
		$this->assertEquals($cards, \iterator_to_array($this->cards));
	}
	public function testReverse()
	{
		$cards = [FakeCard::fromUuid('aaa'), FakeCard::fromUuid('bbb')];
		$this->cards = new DsCards(...$cards);
		$this->assertEquals(\array_reverse($cards), \iterator_to_array($this->cards->reverse()));
	}
	public function testTurnAll()
	{
		$cards = [
			FakeCard::fromUuid('hello'),
			FakeCard::fromUuid('world'),
		];
		$turnedCards = [
			FakeCard::fromUuid('hello', CardVisibility::faceUp()),
			FakeCard::fromUuid('world', CardVisibility::faceUp()),
		];
		$this->cards = new DsCards(...$cards);
		$this->assertEquals($turnedCards, \iterator_to_array($this->cards->turnAll()));
	}
}