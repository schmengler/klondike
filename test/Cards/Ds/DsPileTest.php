<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Card;
use SSE\Cards\CardVisibility;
use SSE\Cards\Fake\FakeCard;
use SSE\Cards\InvalidPileOperation;
use SSE\Cards\PileWithValidation;

/**
 * @covers DsPile
 */
class DsPileTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var DsPile
	 */
	private $pile;
	private function createPileWithCards(Card ...$cards)
	{
		$this->pile = new PileWithValidation(DsPile::fromSingleCards(...$cards));
	}
	public function testInstantiation()
	{
		$cards = [
			FakeCard::fromUuid('card-1'),
			FakeCard::fromUuid('card-2'),
		];
		$this->assertEquals(
			$cards,
			\iterator_to_array(DsPile::fromSingleCards(...$cards)->all())
		);
	}
	public function testTake()
	{
		$cards = [
			FakeCard::fromUuid('xxx'),
			FakeCard::fromUuid('yyy'),
			FakeCard::fromUuid('zzz')
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertCount(1, $this->pile->top(1));
		$this->assertEquals([$cards[2]], \iterator_to_array($this->pile->top(1)));

		$this->assertCount(3, $this->pile->top(3));
		$this->assertEquals($cards, \iterator_to_array($this->pile->top(3)));
		
		$this->setExpectedException(InvalidPileOperation::class, 'Cannot take 4 cards from pile of 3 cards');
		$this->pile->top(4);
	}
	
	public function testTakeAll()
	{
		$cards = [
			FakeCard::fromUuid('first-of-all'),
			FakeCard::fromUuid('second-of-all'),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertCount(2, $this->pile->all());
		$this->assertEquals($cards, \iterator_to_array($this->pile->all()));
	}
	
	public function testDrop()
	{
		$cards = [
			FakeCard::fromUuid('aaa'),
			FakeCard::fromUuid('bbb'),
			FakeCard::fromUuid('ccc'),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertEquals([$cards[0], $cards[1]], \iterator_to_array($this->pile->drop(1)->all()));
		$this->assertEquals($cards, \iterator_to_array($this->pile->all()), 'Original pile should be unchanged');

		$this->setExpectedException(InvalidPileOperation::class, 'Cannot drop 4 cards from pile of 3 cards');
		$this->pile->drop(4);
	}
	
	public function testDropAll()
	{
		$cards = [
			FakeCard::fromUuid('foo'),
			FakeCard::fromUuid('bar'),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertEquals([], \iterator_to_array($this->pile->dropAll()->all()));
		$this->assertEquals($cards, \iterator_to_array($this->pile->all()), 'Original pile should be unchanged');
	}
	
	public function testAdd()
	{
		$cards = [
			FakeCard::fromUuid('moo'),
			FakeCard::fromUuid('woof'),
		];
		$cardsToAdd = [
			FakeCard::fromUuid('meow'),
			FakeCard::fromUuid('quack'),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertEquals(\array_merge($cards, $cardsToAdd),
				\iterator_to_array($this->pile->add(DsCards::fromCards(...$cardsToAdd))->all()));
		$this->assertEquals($cards, \iterator_to_array($this->pile->all()), 'Original pile should be unchanged');
	}
	
	public function testTurnTopCard()
	{
		$cards = [
			FakeCard::fromUuid('bottom-secret', CardVisibility::faceDown()),
			FakeCard::fromUuid('top-secret', CardVisibility::faceDown()),
		];
		$this->createPileWithCards(...$cards);
		
		$this->assertEquals([
				FakeCard::fromUuid('bottom-secret', CardVisibility::faceDown()),
				FakeCard::fromUuid('top-secret', CardVisibility::faceUp()),
		], \iterator_to_array($this->pile->turnTopCard()->all()));
		$this->assertEquals($cards, \iterator_to_array($this->pile->all()), 'Original pile should be unchanged');
	}
	public function testTurnTopCardOnEmptyPile()
	{
		$this->setExpectedException(InvalidPileOperation::class, 'Cannot turn top card of empty pile');
		$this->createPileWithCards();
		$this->pile->turnTopCard();
	}
}