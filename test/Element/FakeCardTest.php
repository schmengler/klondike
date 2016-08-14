<?php
namespace Klondike\Element;

use Klondike\Value\CardVisibility;
class FakeCardTest extends \PHPUnit_Framework_TestCase
{
	public function testEquality()
	{
		$this->assertEquals(new FakeCard('xxx'), new FakeCard('xxx'));
		$this->assertNotEquals(new FakeCard('xxx'), new FakeCard('yyy'));
	}
	public function testEqualityWithVisibility()
	{		
		$this->assertEquals(
				new FakeCard('xxx'),
				new FakeCard('xxx', CardVisibility::faceDown()), 'default should be face down');
		$this->assertEquals(
				new FakeCard('xxx', CardVisibility::faceDown()),
				new FakeCard('xxx', CardVisibility::faceDown()));
		$this->assertNotEquals(
				new FakeCard('xxx', CardVisibility::faceDown()),
				new FakeCard('xxx', CardVisibility::faceUp()));
	}
	public function testTurnOver()
	{
		$card = new FakeCard('yyy');
		$this->assertEquals(new FakeCard('yyy', CardVisibility::faceUp()), $card->turnOver());
	}
}