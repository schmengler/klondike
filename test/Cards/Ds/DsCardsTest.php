<?php
namespace SSE\Cards\Ds;

use SSE\Cards\Cards;
use SSE\Cards\CardVisibility;
use SSE\Cards\Fake\FakeCard;

/**
 * @covers SSE\Cards\Ds\DsCards
 */
class DsCardsTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var DsCards
	 */
	private $cards;
	public function testIterator()
	{
		$cards = [FakeCard::fromUuid('xxx'), FakeCard::fromUuid('yyy')];
		$this->cards = DsCards::fromCards(...$cards);
		$this->assertEquals($cards, \iterator_to_array($this->cards));
	}
	public function testCount()
    {
        $cards = [FakeCard::fromUuid('oans'), FakeCard::fromUuid('zwoa')];
        $this->cards = DsCards::fromCards(...$cards);
        $this->assertEquals(\count($cards), $this->cards->count());
    }
	public function testReverse()
	{
		$cards = [FakeCard::fromUuid('aaa'), FakeCard::fromUuid('bbb')];
		$this->cards = DsCards::fromCards(...$cards);
		$this->assertEquals(\array_reverse($cards), \iterator_to_array($this->cards->reverse()));
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
        $subject = DsCards::fromCards(FakeCard::fromUuid('id-1'), FakeCard::fromUuid('id-2'), FakeCard::fromUuid('id-3'));
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
                DsCards::fromCards(FakeCard::fromUuid('a-1'), FakeCard::fromUuid('a-2'), FakeCard::fromUuid('a-3')),
                DsCards::fromCards(FakeCard::fromUuid('b-1'), FakeCard::fromUuid('b-2')),
                DsCards::fromCards(FakeCard::fromUuid('a-1'), FakeCard::fromUuid('a-2'), FakeCard::fromUuid('a-3'), FakeCard::fromUuid('b-1'), FakeCard::fromUuid('b-2')),
            ]
        ];
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
		$this->cards = DsCards::fromCards(...$cards);
		$this->assertEquals($turnedCards, \iterator_to_array($this->cards->turnAll()));
	}
}