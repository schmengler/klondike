<?php
namespace Klondike\Element;

use Klondike\Value\CardID;
use Klondike\Value\CardValue;
use Klondike\Value\Suit;
use Klondike\Value\Rank;
use Klondike\Value\CardVisibility;

class DsPileTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var DsPile
	 */
	private $pile;
	private function createPileWithCards(Card ...$cards)
	{
		$this->pile = new PileValidation(DsPile::fromSingleCards(...$cards));
	}
	public function testInstantiation()
	{
		$cards = [
			new FakeCard('card-1'),
			new FakeCard('card-2'),
		];
		$this->assertEquals(
			$cards,
			\iterator_to_array(DsPile::fromSingleCards(...$cards)->takeAll())
		);
	}
	public function testTake()
	{
		$cards = [
			new FakeCard('xxx'),
			new FakeCard('yyy'),
			new FakeCard('zzz')
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertCount(1, $this->pile->take(1));
		$this->assertEquals([$cards[2]], \iterator_to_array($this->pile->take(1)));

		$this->assertCount(3, $this->pile->take(3));
		$this->assertEquals($cards, \iterator_to_array($this->pile->take(3)));
		
		$this->setExpectedException(InvalidPileOperationException::class, 'Cannot take 4 cards from pile of 3 cards');
		$this->pile->take(4);
	}
	
	public function testTakeAll()
	{
		$cards = [
			new FakeCard('first-of-all'),
			new FakeCard('second-of-all'),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertCount(2, $this->pile->takeAll());
		$this->assertEquals($cards, \iterator_to_array($this->pile->takeAll()));
	}
	
	public function testDrop()
	{
		$cards = [
			new FakeCard('aaa'),
			new FakeCard('bbb'),
			new FakeCard('ccc'),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertEquals([$cards[0], $cards[1]], \iterator_to_array($this->pile->drop(1)->takeAll()));
		$this->assertEquals($cards, \iterator_to_array($this->pile->takeAll()), 'Original pile should be unchanged');

		$this->setExpectedException(InvalidPileOperationException::class, 'Cannot drop 4 cards from pile of 3 cards');
		$this->pile->drop(4);
	}
	
	public function testDropAll()
	{
		$cards = [
			new FakeCard('foo'),
			new FakeCard('bar'),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertEquals([], \iterator_to_array($this->pile->dropAll()->takeAll()));
		$this->assertEquals($cards, \iterator_to_array($this->pile->takeAll()), 'Original pile should be unchanged');
	}
	
	public function testAdd()
	{
		$cards = [
			new FakeCard('moo'),
			new FakeCard('woof'),
		];
		$cardsToAdd = [
			new FakeCard('meow'),
			new FakeCard('quack'),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertEquals(\array_merge($cards, $cardsToAdd),
				\iterator_to_array($this->pile->add(new DsCards(...$cardsToAdd))->takeAll()));
		$this->assertEquals($cards, \iterator_to_array($this->pile->takeAll()), 'Original pile should be unchanged');
	}
	
	public function testTurnTopCard()
	{
		$cards = [
			new FakeCard('bottom-secret', CardVisibility::faceDown()),
			new FakeCard('top-secret', CardVisibility::faceDown()),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertEquals([
				new FakeCard('bottom-secret', CardVisibility::faceDown()),
				new FakeCard('top-secret', CardVisibility::faceUp()),
		], \iterator_to_array($this->pile->turnTopCard()->takeAll()));
		$this->assertEquals($cards, \iterator_to_array($this->pile->takeAll()), 'Original pile should be unchanged');
	}
	public function testTurnTopCardOnEmptyPile()
	{
		$this->setExpectedException(InvalidPileOperationException::class, 'Cannot turn top card of empty pile');
		$this->createPileWithCards();
		$this->pile->turnTopCard();
	}
}