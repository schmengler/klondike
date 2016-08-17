<?php
namespace SSE\Cards;

/**
 * @covers SSE\Cards\CardVisibility
 */
class CardVisibilityTest extends \PHPUnit_Framework_TestCase
{
	public function testEquality()
	{
		$this->assertEquals(CardVisibility::faceDown(), CardVisibility::faceDown());
		$this->assertEquals(CardVisibility::faceUp(), CardVisibility::faceUp());
		$this->assertNotEquals(CardVisibility::faceDown(), CardVisibility::faceUp());
	}
	
	public function testOpposite()
	{
		$this->assertEquals(CardVisibility::faceDown(), CardVisibility::faceUp()->opposite());
		$this->assertEquals(CardVisibility::faceUp(), CardVisibility::faceDown()->opposite());
	}
}