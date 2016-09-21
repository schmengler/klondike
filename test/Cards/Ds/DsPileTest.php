<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Card;
use SSE\Cards\CardVisibility;
use SSE\Cards\Fake\FakeCard;
use SSE\Cards\Fake\FakeCards;
use SSE\Cards\PileID;

/**
 * @covers SSE\Cards\Ds\DsPile
 */
class DsPileTest extends \PHPUnit_Framework_TestCase
{
	private function createPileWithCards(Card ...$cards) : DsPile
	{
		return DsPile::fromSingleCards(new PileID('the-pile'), ...$cards);
	}
	public function testInstantiation()
	{
		$cards = [
			FakeCard::fromUuid('card-1'),
			FakeCard::fromUuid('card-2'),
		];
		$this->assertEquals(
			$cards,
			\iterator_to_array($this->createPileWithCards(...$cards)->all())
		);
	}
	public function testTop()
	{
		$cards = [
			FakeCard::fromUuid('xxx'),
			FakeCard::fromUuid('yyy'),
			FakeCard::fromUuid('zzz')
		];
		$pile = $this->createPileWithCards(...$cards);
		
		$this->assertCount(1, $pile->top(1));
		$this->assertEquals([$cards[2]], \iterator_to_array($pile->top(1)));

		$this->assertCount(3, $pile->top(3));
		$this->assertEquals($cards, \iterator_to_array($pile->top(3)));
	}
	
	public function testAll()
	{
		$cards = [
			FakeCard::fromUuid('first-of-all'),
			FakeCard::fromUuid('second-of-all'),
		];
        $pile = $this->createPileWithCards(...$cards);
		
		$this->assertCount(2, $pile->all());
		$this->assertEquals($cards, \iterator_to_array($pile->all()));
	}
	public function testCount()
    {
        $pile = $this->createPileWithCards(...FakeCards::fromUuids('un', 'deux', 'trois'));
        $this->assertEquals(3, $pile->count());
    }
    public function testCountVisible()
    {
        $pile = $this->createPileWithCards(...FakeCards::fromUuids('eins', 'zwei')->merge(FakeCards::fromUuids('drei', 'vier', 'fünf')->turnAll()));
        $this->assertEquals(3, $pile->countVisible());
    }
	public function testDrop()
	{
		$cards = [
			FakeCard::fromUuid('aaa'),
			FakeCard::fromUuid('bbb'),
			FakeCard::fromUuid('ccc'),
		];
        $pile = $this->createPileWithCards(...$cards);
		
		$this->assertEquals([$cards[0], $cards[1]], \iterator_to_array($pile->drop(1)->all()));
		$this->assertEquals($cards, \iterator_to_array($pile->all()), 'Original pile should be unchanged');
	}
	
	public function testDropAll()
	{
		$cards = [
			FakeCard::fromUuid('foo'),
			FakeCard::fromUuid('bar'),
		];
        $pile = $this->createPileWithCards(...$cards);
		
		$this->assertEquals([], \iterator_to_array($pile->dropAll()->all()));
		$this->assertEquals($cards, \iterator_to_array($pile->all()), 'Original pile should be unchanged');
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
        $pile = $this->createPileWithCards(...$cards);
		
		$this->assertEquals(\array_merge($cards, $cardsToAdd),
				\iterator_to_array($pile->add(DsCards::fromCards(...$cardsToAdd))->all()));
		$this->assertEquals($cards, \iterator_to_array($pile->all()), 'Original pile should be unchanged');
	}
	
	public function testTurnTopCard()
	{
		$cards = [
			FakeCard::fromUuid('bottom-secret', CardVisibility::faceDown()),
			FakeCard::fromUuid('top-secret', CardVisibility::faceDown()),
		];
        $pile = $this->createPileWithCards(...$cards);
		
		$this->assertEquals([
				FakeCard::fromUuid('bottom-secret', CardVisibility::faceDown()),
				FakeCard::fromUuid('top-secret', CardVisibility::faceUp()),
		], \iterator_to_array($pile->turnTopCard()->all()));
		$this->assertEquals($cards, \iterator_to_array($pile->all()), 'Original pile should be unchanged');
	}
}