<?php
namespace SSE\Cards\Fake;

use SSE\Cards\Cards;

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
}