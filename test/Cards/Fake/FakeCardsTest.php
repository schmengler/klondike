<?php
namespace SSE\Cards\Fake;

use SSE\Cards\Card;
use SSE\Cards\Cards;
use SSE\Cards\CardVisibility;

/**
 * @covers SSE\Cards\Fake\FakeCards
 */
class FakeCardsTest extends \PHPUnit_Framework_TestCase
{
	public function testIterator()
	{
		$expectedCards = [FakeCard::fromUuid('id-1'), FakeCard::fromUuid('id-2'), FakeCard::fromUuid('id-3')];
		$cards = FakeCards::fromUuids('id-1', 'id-2', 'id-3');
		$this->assertEquals($expectedCards, \iterator_to_array($cards));
	}
	public function testReverse()
	{
		$expectedCards = [FakeCard::fromUuid('id-3'), FakeCard::fromUuid('id-2'), FakeCard::fromUuid('id-1')];
		$cards = FakeCards::fromUuids('id-1', 'id-2', 'id-3');
		$this->assertEquals($expectedCards, \iterator_to_array($cards->reverse()));
	}
	public function testFirst()
    {
        $cards = FakeCards::fromUuids('first', 'second');
        $this->assertEquals(FakeCard::fromUuid('first'), $cards->first());
    }
    public function testLast()
    {
        $cards = FakeCards::fromUuids('second-last', 'last');
        $this->assertEquals(FakeCard::fromUuid('last'), $cards->last());
    }
    /**
     * @dataProvider dataSlice
     */
	public function testSlice(Cards $subject, int $sliceFrom = null, int $sliceTo = null, array $expectedCards)
    {
        $this->assertEquals($expectedCards, \iterator_to_array($subject->slice($sliceFrom, $sliceTo)));
    }
    public static function dataSlice()
    {
        $subject = FakeCards::fromUuids('id-1', 'id-2', 'id-3');
        return [
            [$subject, 0, 1, [FakeCard::fromUuid('id-1')]],
            [$subject, 0, -1, [FakeCard::fromUuid('id-1'), FakeCard::fromUuid('id-2')]],
            [$subject, -1, null, [FakeCard::fromUuid('id-3')]],
        ];
    }

    /**
     * @dataProvider dataMerge
     */
    public function testMerge(Cards $subject, Cards $cardsToMerge, Cards $expected)
    {
        $this->assertEquals($expected, $subject->merge($cardsToMerge));
    }
    public static function dataMerge()
    {
        return [
            [
                FakeCards::fromUuids('a-1', 'a-2', 'a-3'),
                FakeCards::fromUuids('b-1', 'b-2'),
                FakeCards::fromUuids('a-1', 'a-2', 'a-3', 'b-1', 'b-2'),
            ]
        ];
    }

    public function testFilter()
    {
        $cards = FakeCards::fromUuids('aa', 'ab', 'ba', 'bb');
        $this->assertEquals(
            FakeCards::fromUuids('aa', 'ab'),
            $cards->filter(function(Card $card) {
                return \substr($card->id(), 0, 1) === 'a';
            })
        );
    }

    public function testTurnAll()
    {
        $subject = FakeCards::fromUuids('tick', 'trick', 'track');
        $turned = $subject->turnAll();
        $this->assertCount(\count($subject), $turned);
        foreach ($turned as $card) {
            $this->assertEquals(CardVisibility::faceUp(), $card->visibility());
        }
    }
}