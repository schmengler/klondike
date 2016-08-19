<?php
namespace SSE\Cards\Fake;


use SSE\Cards\CardVisibility;

class FakePileTest extends \PHPUnit_Framework_TestCase
{
    private function createPileWithCards(string ...$uuids) : FakePile
    {
        return FakePile::fromUuids(...$uuids);
    }
    public function testInstantiation()
    {
        $cards = [
            FakeCard::fromUuid('card-1'),
            FakeCard::fromUuid('card-2'),
        ];
        $this->assertEquals(
            $cards,
            \iterator_to_array($this->createPileWithCards('card-1', 'card-2')->all())
        );
    }
    public function testTake()
    {
        $cards = [
            FakeCard::fromUuid('xxx'),
            FakeCard::fromUuid('yyy'),
            FakeCard::fromUuid('zzz')
        ];
        $pile = $this->createPileWithCards('xxx', 'yyy', 'zzz');

        $this->assertCount(1, $pile->top(1));
        $this->assertEquals([$cards[2]], \iterator_to_array($pile->top(1)));

        $this->assertCount(3, $pile->top(3));
        $this->assertEquals($cards, \iterator_to_array($pile->top(3)));
    }

    public function testTakeAll()
    {
        $cards = [
            FakeCard::fromUuid('first-of-all'),
            FakeCard::fromUuid('second-of-all'),
        ];
        $pile = $this->createPileWithCards('first-of-all', 'second-of-all');

        $this->assertCount(2, $pile->all());
        $this->assertEquals($cards, \iterator_to_array($pile->all()));
    }

    public function testDrop()
    {
        $cards = [
            FakeCard::fromUuid('aaa'),
            FakeCard::fromUuid('bbb'),
            FakeCard::fromUuid('ccc'),
        ];
        $pile = $this->createPileWithCards('aaa', 'bbb', 'ccc');

        $this->assertEquals([$cards[0], $cards[1]], \iterator_to_array($pile->drop(1)->all()));
        $this->assertEquals($cards, \iterator_to_array($pile->all()), 'Original pile should be unchanged');
    }

    public function testDropAll()
    {
        $cards = [
            FakeCard::fromUuid('foo'),
            FakeCard::fromUuid('bar'),
        ];
        $pile = $this->createPileWithCards('foo', 'bar');

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
        $pile = $this->createPileWithCards('moo', 'woof');

        $this->assertEquals(\array_merge($cards, $cardsToAdd),
            \iterator_to_array($pile->add(FakeCards::fromUuids('meow', 'quack'))->all()));
        $this->assertEquals($cards, \iterator_to_array($pile->all()), 'Original pile should be unchanged');
    }

    public function testTurnTopCard()
    {
        $cards = [
            FakeCard::fromUuid('bottom-secret', CardVisibility::faceDown()),
            FakeCard::fromUuid('top-secret', CardVisibility::faceDown()),
        ];
        $pile = $this->createPileWithCards('bottom-secret', 'top-secret');

        $this->assertEquals([
            FakeCard::fromUuid('bottom-secret', CardVisibility::faceDown()),
            FakeCard::fromUuid('top-secret', CardVisibility::faceUp()),
        ], \iterator_to_array($pile->turnTopCard()->all()));
        $this->assertEquals($cards, \iterator_to_array($pile->all()), 'Original pile should be unchanged');
    }

}
