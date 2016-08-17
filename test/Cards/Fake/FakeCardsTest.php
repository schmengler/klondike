<?php
namespace SSE\Cards\Fake;

class FakeCardsTest extends \PHPUnit_Framework_TestCase
{
	public function testIterator()
	{
		$expectedCards = [new FakeCard('id-1'), new FakeCard('id-2'), new FakeCard('id-3')];
		$cards = FakeCards::fromUuids('id-1', 'id-2', 'id-3');
		$this->assertEquals($expectedCards, \iterator_to_array($cards));
	}
	public function testReverse()
	{
		$expectedCards = [new FakeCard('id-3'), new FakeCard('id-2'), new FakeCard('id-1')];
		$cards = FakeCards::fromUuids('id-1', 'id-2', 'id-3');
		$this->assertEquals($expectedCards, \iterator_to_array($cards->reverse()));
	}
}