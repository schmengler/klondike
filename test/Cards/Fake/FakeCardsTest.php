<?php
namespace SSE\Cards\Fake;

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
}