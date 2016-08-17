<?php
namespace SSE\Cards\Fake;

use SSE\Cards\CardVisibility;

/**
 * @covers SSE\Cards\Fake\FakeCard
 */
class FakeCardTest extends \PHPUnit_Framework_TestCase
{
	public function testEquality()
	{
		$this->assertEquals(FakeCard::fromUuid('xxx'), FakeCard::fromUuid('xxx'));
		$this->assertNotEquals(FakeCard::fromUuid('xxx'), FakeCard::fromUuid('yyy'));
	}
	public function testEqualityWithVisibility()
	{		
		$this->assertEquals(
				FakeCard::fromUuid('xxx'),
				FakeCard::fromUuid('xxx', CardVisibility::faceDown()), 'default should be face down');
		$this->assertEquals(
				FakeCard::fromUuid('xxx', CardVisibility::faceDown()),
				FakeCard::fromUuid('xxx', CardVisibility::faceDown()));
		$this->assertNotEquals(
				FakeCard::fromUuid('xxx', CardVisibility::faceDown()),
				FakeCard::fromUuid('xxx', CardVisibility::faceUp()));
	}
	public function testTurnOver()
	{
		$card = FakeCard::fromUuid('yyy');
        $this->assertEquals(CardVisibility::faceDown(), $card->visibility());
		$this->assertEquals(FakeCard::fromUuid('yyy', CardVisibility::faceUp()), $card->turnOver());
	}
}